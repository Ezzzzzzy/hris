<?php

namespace App\Http\Controllers;

use Mail;
use Validator;
use Carbon\Carbon;
use App\Classes\Paginate;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Jobs\BulkAddMembers;
use App\Models\AddressCity;
use App\Models\BranchWorkHistory;
use App\Models\ClientWorkHistory;
use App\Models\Client;
use App\Models\DocumentType;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Document;
use App\Models\EmploymentStatus;
use App\Models\EmploymentHistory;
use App\Models\Location;
use App\Models\Member;
use App\Models\MobileNumber;
use App\Models\Position;
use App\Models\TenureType;
use App\Models\School;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query('page') ? $request->query('page') : 1;
            $limit = $request->query('limit') ? $request->query('limit') : 10;
            $result = Member::allMembers();
    
            //filter
            $filter = ["position", "brand", "location", "complete"];
            $multiple_filter = ["status", "tenure"];
    
            if ($request->query()) {
                $str_queries = $request->query();
    
                foreach ($str_queries as $key => $value) {
                    if (in_array($key, $filter)) {
                        if ($key !== "complete") {
                            $key = $key . "_id";
                        }
                        $result = $this->filter($result, $key, $value);
                    }
    
                    if (in_array($key, $multiple_filter)) {
                        $key = $key . "_id";
                        $value = explode(",", $value);
                        $result = $this->multiFilter($result, $key, $value);
                    }
                }
            }
    
            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }
    
            // search
            if ($request->query('q')) {
                $keyword = $request->query('q');
                $result = $this->search($result, $keyword);
            }
    
            $result = new Paginate(collect($result), $page, $limit);
            return $result::paginate();
        } catch (QueryException $e) {
            return Response::json([
                'status' => 1100,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'permanent_address' => 'required',
            'permanent_address_city' => 'required',
            'present_address' => 'required',
            'present_address_city' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            'birthdate' => 'required',
            'birthplace' => 'required',
            'mobile_number' => 'required',
            // 'telephone_number' => 'required',
            'references_data' => 'required',
            'school_data' => 'required',
            'emp_history_data' => 'required',
            'family_data' => 'required',
            'emergency_data' => 'required',
            'email_address' => 'required',
            'last_modified_by' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                "status" => 1000,
                "error" => $validator->errors()->first()
            ], 422);
        }

        try {
            $member = new Member;
            
            if ($member->create($request->all())) {
                \DB::commit();
                return new MemberResource($member, 201);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollBack();
            return Response::json([
                "errors" => $e->getMessage(),
                "status" => 1151
            ], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            $errors = collect($e->errors());
            return Response::json([
                "errors" => $errors->first()[0],
                "status" => 1000
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = Member::findOrFail($id);

            return Response::json(new MemberResource($result));
        } catch (QueryException $e) {
            return Response::json([
                "error" => $e->getMessage(),
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => $e->getMessage(),
                "status" => 1155
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $member = Member::findOrFail($id);

            $validator = Validator::make($request->all(), [
                // 'existing_member_id' => "required|unique:members,existing_member_id,". $member->id,
                'first_name' => 'required',
                'last_name' => 'required',
                'permanent_address' => 'required',
                'permanent_address_city' => 'required',
                'present_address' => 'required',
                'present_address_city' => 'required',
                'gender' => 'required',
                'civil_status' => 'required',
                'birthdate' => 'required',
                // 'birthplace' => 'required',
                // 'mobile_number' => 'required',
                // 'telephone_number' => 'required',
                // 'references_data' => 'required',
                // 'school_data' => 'required',
                // 'emp_history_data' => 'required',
                // 'family_data' => 'required',
                // 'emergency_data' => 'required',
                // 'email_address' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            if ($member->updateMember($request->all(), $id)) {
                \DB::commit();
                return new MemberResource($member, 201);
            }

            return Response::json(['status' => 1152], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => $e->getMessage(),
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            if ($member->delete()) {
                return Response::json(null, 204);
            }

            return Response::json(['status' => 1154], 500);
        } catch (QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * Returns all history of a member in all branches
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function memberWorkHistory($id)
    {
        try {
            $result = Member::memberWorkHistory($id);

            return Response::json(["data" => $result]);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Member not found.",
                "status" => 1100
            ], 404);
        } catch (QueryException $e) {
            return Response::json(["error" => $e->getMessage()]);
            return Response::json([
                "error" => "Server Error",
                "status" => 1150
            ], 500);
        }
    }

    public function memberDocuments($id)
    {
        try {
            $result = Member::getDocuments($id);

            return Response::json(['data' => $result]);
        } catch (ModelNotFoundException $e) {
            return Response::json(['status' => 1100], 404);
        }
    }

    private function filter($result, $key, $filter)
    {
        return $result->where($key, $filter)->values();
    }

    private function multiFilter($result, $key, $filter)
    {
        return $result->whereIn($key, $filter)->values();
    }

    public function fileUpload(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "document_type_id" => "required",
                "fileList" => "required",
                "last_modified_by" => "required",
                ]);
                
            if ($validator->fails()) {
                return Response::json([
                        "error" => $validator->errors()->first(),
                        "status" => 1000
                    ], 422);
            }

            $member = Member::findOrFail($id);
            
            $document_type = DocumentType::findOrFail($request->document_type_id);

            // s3 process
            $file = $request->file('fileList');
            $md5Name = md5_file($file->getRealPath());
            $guessExtension = $file->getClientOriginalExtension();
            $filename = $md5Name.".".$guessExtension;
            $s3 = \Storage::disk('s3');
            $filePath = 'documents/' . $filename;
            $s3->put($filePath, file_get_contents($file), 'public');
            
            $document = new Document();
            $document->document_name = $request->file('fileList')->getClientOriginalName();
            $document->path = $md5Name;
            $document->s3_link = Storage::disk('s3')->url($filePath);
            $document->member()->associate($member);
            $document->documentType()->associate($member);
            $document->documentType()->associate($document_type);
            $document->save();

            \DB::commit();
            return Response::json([
                "data" => $document
            ], 201);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "status" => 1100,
                "error" => $e->getMessage()
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "status" => 1150,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function importCsv(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->path();

            $handle = fopen($path, "r");
            $header = true;

            $members = Excel::load($path, function ($reader) {
                $reader->each(function ($row) {
                });
            })->parsed;

            BulkAddMembers::dispatch($members, $user->email);
            return Response::json(['message'=>"We will notify you through email when the uploading is done"]);
        } else {
            return Response::json(['message'=>'error you did not pass a file'], 500);
        }
    }
    
    /**
     * Search the list of resource
     *
     * @param Illuminate\Support\Collection $result
     * @param string $keyword
     * @return Illuminate\Support\Collection
     */
    private function search($result, $keyword)
    {
        return $result->filter(function ($item) use ($keyword) {
            return false !== (stristr($item["name"], $keyword) || stristr($item["member_id"], $keyword));
        })->values();
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
                $result = $result->sortByDesc(function ($col) use ($value) {
                    if ($value === "hiring_date") {
                        return Carbon::parse($col["hiring_date"]);
                    } else {
                        return $col[$value];
                    }
                });
            } else {
                $result = $result->sortBy(function ($col) use ($value) {
                    if ($value === "hiring_date") {
                        return Carbon::parse($col["hiring_date"]);
                    } else {
                        return $col[$value];
                    }
                });
            }
        }

        return $result->values();
    }

    /**
     * Bulk upload of member
     */
    public function bulkUploadMember(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "import_file" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "status" => 1000,
                    "error" =>  $validator->errors()->first()
                ], 422);
            }

            $path = $request->file("import_file")->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();

            $errors = collect([]);
            $rows = $data
            ->unique()
            ->values()
            ->filter(function ($item, $key) use ($errors) {
                $row_number = "ROW #" . ($key+2) . ": " ;

                $default_fields = [
                    "existing_member_id", "nickname", "last_name", "first_name", "middle_name", "extension_name",
                    "present_address", "present_address_city", "permanent_address", "permanent_address_city",
                    "tin", "sss_num", "philhealth_num", "pag_ibig_num",
                    "height", "weight", "fb_address", "email_address", "civil_status", "gender",
                    "birthplace", "birthdate", "educational_attainment", "course",
                    "branch_deployed", "brand_deployed", "business_unit_deployed", "client_deployed",
                    "start_date_with_client", "deployment_status", "position", "atm", "rate", "contact_number"
                ];

                $required_fields = [
                    "last_name", "first_name", "present_address", "present_address_city",
                    "sss_num", "philhealth_num", "pag_ibig_num", "email_address",
                    "civil_status", "gender", "birthdate", "educational_attainment", "course",
                ];

                // if headers does not match
                $headers = $item->keys()->all();
                foreach ($headers as $header) {
                    if (!in_array($header, $default_fields)) {
                        $errors->push("Column " . strtoupper($header) .  " is missing.");
                        return ;
                    }
                }

                foreach ($required_fields as $field) {
                    if ($field === "" || is_null($field)) {
                        $errors->push($row_number . $field . " is required.");
                        return ;
                    }
                }

                // if member has the same first_name + middle_name + last_name + birthdate is cloned or duplicated
                $birthdate = date("Y-m-d", strtotime($item["birthdate"]));
                $current = $item["first_name"] . " " . $item["last_name"] . " " . $birthdate;
                
                $members_validate_unique = Member::select(
                    \DB::raw("CONCAT(first_name,' ', last_name, ' ', DATE(birthdate)) as name")
                )->get()
                ->map(function ($item) {
                    return $item->name;
                })
                ->filter(function ($item) use ($current) {
                    return $current === $item;
                })
                ->values()
                ->count();

                if ($members_validate_unique > 0) {
                    $errors->push($item["first_name"] . " " . $item["last_name"] . " already exists.");
                    return ;
                }

                // if government numbers is cloned or duplicated
                $gov_numbers = ["sss_num", "pag_ibig_num", "philhealth_num"];
                foreach ($gov_numbers as $gov_number) {
                    $check_gov_number = Member::where(
                        $gov_number,
                        str_replace("-", "", $item[$gov_number])
                    )->get()->count();
                    if ($check_gov_number > 0) {
                        $errors->push($row_number . $gov_number . " " . $item[$gov_number] . " already exists");
                        return ;
                    }
                }

                $deployment_required_fields = ["client_deployed", "brand_deployed", "branch_deployed"];

                // if member is deployed
                if (strtoupper($item["client_deployed"]) !== "N/A") {
                    // if [Client | Brand | Branch] does not exist
                    foreach ($deployment_required_fields as $value) {
                        $class = ucfirst(substr($value, 0, strpos($value, "_")));
                        $type = "App\Models\\" . $class;
                        $obj = new $type;
    
                        if ($class === "Client") {
                            $check_deployment = $obj->where(str_replace("deployed", "name", $value), $item[$value])
                                                    ->orWhere("code", $item[$value])->get()->count();
                        } else {
                            $check_deployment = $obj->where(
                                str_replace("deployed", "name", $value),
                                $item[$value]
                            )->get()->count();
                        }
    
                        if ($check_deployment <= 0) {
                            $errors->push($row_number . strtoupper($class) . " " . $item[$value] . " does not exist");
                            return ;
                        }
                    }
                }
                
                // check if positions table are filled
                $check_position = Position::all();
                if ($check_position->count() <= 0) {
                    $errors->push("Upload positions first!");
                    return ;
                }

                return $item;
            })
            ->each(function ($item, $key) use ($errors) {
                $new_member_id = Member::max("new_member_id");
                $member = new Member;
                $member->new_member_id = ++$new_member_id;
                $member->fill($item->toArray());
                $member->sss_num = str_replace("-", "", $item["sss_num"]);
                $member->pag_ibig_num = str_replace("-", "", $item["pag_ibig_num"]);
                $member->philhealth_num = str_replace("-", "", $item["philhealth_num"]);
                $member->employment_status_id = EmploymentStatus::where("status_name", $item["deployment_status"])
                ->first()->id;
                $member->save();

                $mobile = new MobileNumber;
                $mobile->number = $item['contact_number'];

                $member->mobileNumbers()->save($mobile);

                if ($item["client_deployed"] !== "N/A") {
                    $cwh = new ClientWorkHistory;
                    $cwh->date_start = $item['start_date_with_client'];
                    $cwh->client_id = Client::where("client_name", $item["client_deployed"])
                                            ->orWhere("code", $item["client_deployed"])
                                            ->first()['id'];
                    $cwh->member_id = $member->id;
                    $cwh->tenure_type_id = null;
                    $cwh->save();
    
                    $bwh = new BranchWorkHistory;
                    $bwh->date_start = $item['start_date_with_client'];
                    $bwh->client_work_history_id = $cwh->id;
                    $bwh->branch_id = Branch::where("branch_name", $item["branch_deployed"])->first()->id;
                    $bwh->position_id = Position::where("position_name", $item["position"])->first()->id;
                    $bwh->save();

                    $employment_history = EmploymentHistory::create([
                        'date_start' => $bwh->date_start,
                        'employment_status_id' => EmploymentStatus::where("status_name", $item["deployment_status"])
                        ->first()->id,
                        'branch_work_history_id' => $bwh->id
                    ]);
                }
            });

            \DB::commit();
            return Response::json([
                "errors" => $errors->unique()->all(),
                "data" => $rows->count() . " row(s) inserted.",
            ]);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "status" => 1100,
                "error" => $e->getMessage()
            ]);
        }
    }
}
