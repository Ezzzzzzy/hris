<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ReportResource;
use App\Models\BranchWorkHistory;
use App\Models\Report;
use App\Models\ReportFilter;
use App\Models\User;
use App\Classes\Paginate;
use Carbon\Carbon;
use Excel;
use Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $page = $request->query("page") ? $request->query("page") : 1;
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $result = Report::getReports();
            $filter = $request->query("saved");

            if (gettype($filter) === "string") {
                $result = $result->filter(function ($item) use ($filter) {
                    return $item->saved == $filter;
                })->values();
            }

            if (gettype($request->query("type")) === "string") {
                $type = $request->query("type");
                $result = $result->filter(function ($item) use ($type) {
                    if (strtolower($item["type"]) == strtolower($type)) {
                        return $item;
                    }
                })->values();
            }

            if ($request->query("start") || $request->query("end")) {
                $start = $request->query("start");
                $end = $request->query("end") ? $request->query("end") : Carbon::now();
                $result = $this->filterDate($result, $start, $end);
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $this->search($result, $keyword)->values();
            }

            $result = new Paginate($result, $page, $limit);
            return Response::json($result::paginate());
        } catch (QueryException $e) {
            return Response::json(["status" => 1150], 500);
        }
    }

    public function show($id)
    {
        try {
            $result = Report::findOrFail($id);
            
            parse_str($result->filters, $filters);
            if ($result->type === "HC") {
                parse_str($result->config, $config);
            } else {
                $config = explode(", ", $result->config);
            }

            return Response::json([
                "data" => [
                    "id" => $result->id,
                    "title" => $result->title,
                    "saved" => $result->saved,
                    "type" => $result->type,
                    "filters" => $filters,
                    "config" => $config,
                    "template_name" => $result->template_name,
                    "last_modified_by" => $result->last_modified_by->user->name,
                    "created_at" => Carbon::parse($result->created_at)->toFormattedDateString()
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        }
    }
    
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required|unique:reports",
                "type" => "required",
                // "filters" => "required",
                "saved" => "required",
                "config" => "required",
                "last_modified_by" => "required"
            ]);
                
            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first()
                ], 422);
            }

            $result = BranchWorkHistory::reportsData();
            $config = $request->config;
            $filters = $request->filters;
            $type = $request->type;

            if ($request->has("filters")) {
                if (count($request->filters) !== 0) {
                    foreach ($filters as $filter_key => $filter) {
                        $result = $result->filter(function ($item, $item_key) use ($filter_key, $filter) {
                            if (strpos($filter_key, "_ms") !== false) {
                                $multi_select_key = str_replace("_ms", "", $filter_key);
                                return in_array($item[$multi_select_key], $filter);
                            }

                            if (strpos($filter_key, "_ss") !== false) {
                                $single_select_key = str_replace("_ss", "", $filter_key);
                                return $item[$single_select_key] === $filter;
                            }

                            if (strpos($filter_key, "_num") !== false) {
                                return ($filter === 1) ? $item[$filter_key] !== "" : $item[$filter_key] === "";
                            }

                            if (strpos($filter_key, "_dr") !== false) {
                                $date_start = Carbon::parse($item["start_date"]);
                                // $date_end = Carbon::parse($item["end_date"]);
                                $from = Carbon::parse($filter["from"]);
                                $to = array_key_exists("to", $filter) ? Carbon::parse($filter["to"]) : Carbon::today();

                                if (!array_key_exists("to", $filter)) {
                                    return $date_start->gte($from);
                                }

                                return $date_start->gte($from) && $date_start->lte($to);
                            }
                        })->values();
                    }
                }
            }

            $report = Report::createReport($validator, $request->all());

            if (strtoupper($type) === "HC") {
                $result = $this->headCount($result, $config);
            } else {
                $result = $this->memberList($result, $config);
            }

            $path = storage_path("\\excel\\reports");

            Excel::create($report->title, function ($excel) use ($result, $report) {
                $sheet_title = ($report->type === "HC") ? "HEADCOUNT" : "MEMBER LIST";
                $excel->setTitle($report->title);
                $excel->setCreator($report->last_modified_by)->setCompany("PeopleServe");
                $excel->sheet($sheet_title, function ($sheet) use ($result) {
                    $sheet->fromArray($result, null);
                });
            })->store("xlsx", $path);

            \DB::commit();
            return Response::json(["file_url" => url("/") . "/download/" . $report->title]);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["status" => 1150, "errors" => $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            return Response::json(["error" => $validator->errors()->first()]);
        }
    }

    private function getCount($levels, $result)
    {
        $main_obj = [];
        $new_level = $levels;

        $new_level--;

        foreach ($result as $key => $value) {
            if ($new_level >= 1) {
                $main_obj[$key] = $this->getCount($new_level, $result[$key]);
            } else {
                $main_obj[$key] = $result[$key]->count();
            }
        }

        return collect($main_obj);
    }
    
    public function reassignKeys($result, $headers, $lvl_count)
    {
        $compiled = collect($this->arrayKeysMulti($result->toArray()));
        $temp_result = [];
        $count = [];
        array_push($headers, "Count");

        foreach ($compiled as $key => $value) {
            if (gettype($value) !== "integer") {
                $temp_arr[] = $value;
            } else {
                $temp_arr[] = $value;
                $temp_result[] = $temp_arr;
                $count[] = count($temp_arr);
                $temp_arr = [];
            }
        }

        foreach ($temp_result as $key => $value) {
            if (count($value) !== max($count)) {
                $difference = max($count) - count($value);
                for ($x=0; $x<$difference; $x++) {
                    array_unshift($temp_result[$key], " ");
                }
            }
        }

        $new_result = [];
        foreach ($temp_result as $key1 => $value) {
            array_push($new_result, array_combine($headers, $value));
        }

        return $new_result;
    }

    private function arrayKeysMulti(array $array)
    {
        $keys = array();
    
        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys = array_merge($keys, $this->arrayKeysMulti($value));
            } else {
                array_push($keys, $value);
            };
        }
    
        return $keys;
    }

    private function getHeaders($levels)
    {
        $index = [];
        $conditions = ["_name", "_id"];

        foreach ($levels as $level) {
            foreach ($conditions as $condition) {
                if (strpos($level, $condition)) {
                    $index[] = str_replace($condition, "", ucfirst($level));
                }
            }
        }

        return $index;
    }

    public function headCount($result, $levels)
    {
        $levels = array_values($levels["levels"]);
        $lvl_count = collect($levels)->count();
        
        $result = $result->groupBy(
            $levels,
            $preserveKeys = false
        );

        $headers = $this->getHeaders($levels);
        $result = $this->getCount($lvl_count, $result);
        $result = $this->reassignKeys($result, $headers, $lvl_count);

        return $result;
    }

    public function memberList($result, $config)
    {
        $new_config = array_map(function ($item) {
            return strtoupper(explode("_", $item)[0]);
        }, $config);

        return $result->map(function ($item) use ($config) {
            $birthdate = Carbon::parse($item["birthdate"]);
            $contact_numbers = collect($item["mobile_numbers"]);
            $contact_numbers = $contact_numbers->merge(collect($item["telephone_numbers"]));
            $item["contact_numbers"] = implode(", ", $contact_numbers->toArray());

            $data = [
                "employee_id" => $item["employee_id"] ? $item["employee_id"] : " - ",
                "full_name" => strtoupper($item["first_name"] . " " . $item["middle_name"] . " " . $item["last_name"]),
                "last" => $item["last_name"] ? $item["last_name"] : " - ",
                "first" => $item["first_name"] ? $item["first_name"] : " - ",
                "middle" => $item["middle_name"] ? $item["middle_name"] : " - ",
                "client" => $item["client_code"] ? $item["client_code"] : " - ",
                "business_unit" => $item["business_unit_code"] ? $item["business_unit_code"] : " - ",
                "position" => $item["position_name"] ? $item["position_name"] : " - ",
                "location" => $item["location_name"] ? $item["location_name"] : " - ",
                "city" => $item["city_name"] ? $item["city_name"] : " - ",
                "region" => $item["region_name"] ? $item["region_name"] : " - ",
                "date_start" => Carbon::parse($item["start_date"] ? $item["start_date"] : " - ")->toFormattedDateString(),
                "birthday" => $birthdate->toFormattedDateString(),
                "age" => $birthdate->diffInYears(Carbon::now()),
                "gender" => $item["gender"] ? $item["gender"] : " - ",
                "status" => $item["employment_status_name"] ? $item["employment_status_name"] : " - ",
                "present_address" => $item["address"] ? $item["address"] : " - ",
                "present_city" => $item["address_city"] ? $item["address_city"] : " - ",
                "personal_email" => $item["email"] ? $item["email"] : " - ",
                "facebook_email" => $item["fb_address"] ? $item["fb_address"] : " - ",
                "contact_numbers" => $item["contact_numbers"] ? $item["contact_numbers"] : " - ",
                "sss" => $item["sss_num"] ? $item["sss_num"] : " - ",
                "tin" => $item["tin_num"] ? $item["tin_num"] : " - ",
                "pagibig" => $item["pagibig_num"] ? $item["pagibig_num"] : " - ",
                "atm" =>  $item["atm"] ? $item["atm"] : " - ",
                "rate" => $item["rate"] ? $item["rate"] : " - ",
                "maternity" => $item["maternity_leave"] ? $item["maternity_leave"] : " - ",
                "reason" => $item["reason"] ? $item["reason"] : " - ",
                //"school" => $item[""]
            ];

            $filtered = array_intersect($config, array_keys($data));

            $result = [];
            $keys = [];
            $values = [];
            foreach ($data as $val) {
                foreach ($filtered as $value) {
                    array_push($values, $data[$value]);
                    array_push($keys, strtoupper(str_replace("_", " ", $value)));
                }
            }

            $result = array_combine($keys, $values);

            return $result;
        })->values();
    }

    public function generateTemplate($id)
    {
        \DB::beginTransaction();
        try {
            $template = Report::findOrFail($id);
            $template["saved"] = 0;
            $result = BranchWorkHistory::reportsData();
            $config = explode(",", $template->config);
            $filters = explode(",", $template->filters);
            $type = $template->type;

            if ($filters && count($filters) !== 0) {
                foreach ($filters as $filter_key => $filter) {
                    $result = $result->filter(function ($item, $item_key) use ($filter_key, $filter) {
                        if (strpos($filter_key, "_ms") !== false) {
                            $multi_select_key = str_replace("_ms", "", $filter_key);
                            return in_array($item[$multi_select_key], $filter);
                        }

                        if (strpos($filter_key, "_ss") !== false) {
                            $single_select_key = str_replace("_ss", "", $filter_key);
                            return $item[$single_select_key] === $filter;
                        }

                        if (strpos($filter_key, "_num") !== false) {
                            return ($filter === 1) ? $item[$filter_key] !== "" : $item[$filter_key] === "";
                        }

                        if (strpos($filter_key, "_dr") !== false) {
                            $date_start = Carbon::parse($item["start_date"]);
                            // $date_end = Carbon::parse($item["end_date"]);
                            $from = Carbon::parse($filter["from"]);
                            $to = array_key_exists("to", $filter) ? Carbon::parse($filter["to"]) : Carbon::today();

                            if (!array_key_exists("to", $filter)) {
                                return $date_start->gte($from);
                            }

                            return $date_start->gte($from) && $date_start->lte($to);
                        }
                    })->values();
                }
            }

            $validator = new Validator;

            $report = Report::createReport($validator, $template->toArray());

            if (strtoupper($type) === "HC") {
                $result = $this->headCount($result, $config);
            } else {
                $result = $this->memberList($result, $config);
            }

            $path = storage_path("\\excel\\reports");
            $title = $template->template_name . " - " . date("Y-m-d", strtotime(Carbon::now()));

            Excel::create($title, function ($excel) use ($result, $report, $title) {
                $sheet_title = ($report->type === "HC") ? "HEADCOUNT" : "MEMBER LIST";
                $excel->setTitle($title);
                $excel->setCreator($report->last_modified_by)->setCompany("PeopleServe");
                $excel->sheet($sheet_title, function ($sheet) use ($result) {
                    $sheet->fromArray($result, null);
                });
            })->store("xlsx", $path);

            \DB::commit();
            return Response::json(["file_url" => url("/") . "/download/" . $title]);
        } catch (QueryException $e) {
            return Response::json([
                "status" => 1150,
                "errors" => $e->getMessage()
            ]);
        }
    }

    /**
     * Sorts the list of resource
     *
     * @param Illuminate\Support\Collection $result
     * @param string $keyword
     * @return Illuminate\Support\Collection
     */
    private function sort($result, $sort)
    {
        $sort = explode(",", $sort);
        foreach ($sort as $key => $value) {
            if ($value[0] === "-") {
                $value = str_replace("-", "", $value);
                $result = $result->sortByDesc($value);
            } else {
                $result = $result->sortBy($value);
            }
        }

        return $result->values();
    }

    /**
     *
     */
    private function search($result, $keyword)
    {
        return $result->filter(function ($item) use ($keyword) {
            return false !== (stristr($item["template_name"], $keyword) || stristr($item["title"], $keyword));
        })->values();
    }

    private function filterDate($result, $start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        return $result->filter(function ($item) use ($start, $end) {
            $date_start = Carbon::parse($item["updated_at"]);
            if ($date_start->between($start, $end)) {
                return $item;
            }
        })->values();
    }

    public function all()
    {
        try {
            $reports = Report::where('saved', 1)->get();
            $results = $reports->map(function ($item) {
                return [
                    'id' => $item->id,
                    'template_name' => $item->template_name,
                    'link' => url("/") . "/download/" . $item->title,
                ];
            });
            return Response::json([
                'data' => $results
            ]);
        } catch (QueryException $e) {
            return Response::json([
                'status' => 1150,
                'errors' => $e->getMessage()
            ]);
        }
    }
}
