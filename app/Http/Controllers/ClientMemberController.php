<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Classes\Paginate;
use App\Models\BranchWorkHistory;
use App\Models\Client;
use App\Models\Member;
use App\Models\ClientWorkHistory;

class ClientMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        try {
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $page = $request->query("page") ? $request->query("page") : 1;
            $result = Client::findOrFail($id);
            $result = $result->getMembers();

            // filter
            $filter = ["position", "status", "gender", "brand", "location"];

            if ($request->query()) {
                $str_queries = $request->query();

                if ($request->query("start") || $request->query("end")) {
                    $start = $request->query("start");
                    $end = $request->query("end") ? $request->query("end") : Carbon::now();
                    $result = $this->filterDate($result, $start, $end);
                }

                foreach ($str_queries as $key => $value) {
                    if (in_array($key, $filter)) {
                        if ($key === "gender") {
                            if ($key === "gender") {
                                $value = strtoupper($value);
                            }
                        } else {
                            $key = $key . "_id";
                        }
                        $result = $this->filter($result, $key, $value);
                    }
                }
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $this->search($result, $keyword);
            }

            $result = new Paginate($result, $page, $limit);
            return Response::json($result::paginate());
        } catch (QueryException $e) {
            return Response::json([
                "error" => $e->getMessage(),
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Client not found.",
                "status" => 1155
            ], 404);
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
            return false !== stristr($item["name"], $keyword);
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
                    if ($value === "date_start") {
                        return Carbon::parse($col["date_start"]);
                    } else {
                        return $col[$value];
                    }
                });
            } else {
                $result = $result->sortBy(function ($col) use ($value) {
                    if ($value === "date_start") {
                        return Carbon::parse($col["date_start"]);
                    } else {
                        return $col[$value];
                    }
                });
            }
        }

        return $result->values();
    }

    /**
     * Filter the list of resource
     *
     * @param Illuminate\Support\Collection $result
     * @param string $key
     * @param string $filter
     * @return Illuminate\Support\Collection $result
     */
    private function filter($result, $key, $filter)
    {
        return $result->where($key, $filter)->values();
    }

    /**
     *
     */
    private function filterDate($result, $start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        return $result->filter(function($item) use ($start, $end) {
            $date_start = Carbon::parse($item["date_start"]);
            if($date_start->between($start, $end)) {
                return $item;
            }
        })->values();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function endTenure(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "cwh_ids" => "required|array",
                "date_end" => "required",
                "reason_id" => "required",
                "employment_status_id" => "required",
                "last_modified_by" => "required"
            ]);
            
            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $client = Client::findOrFail($id);

            $cwhs = ClientWorkHistory::whereIn("id", $request->cwh_ids)->get(["id", "member_id"]);

            $cwh_ids = $cwhs->map(function ($item) {
                return $item->id;
            })->values();
            
            $bwh = BranchWorkHistory::whereIn("client_work_history_id", $cwh_ids)
                                      ->where("date_end", null)
                                      ->orWhere("date_end", ">", $request->date_end)
                                      ->first();

            foreach ($cwhs as $cwh) {
                $cwh->date_end = $request->date_end;
                $cwh->save();
            }

            if (!is_null($bwh)) {
                $bwh->date_end = $request->date_end;
                $bwh->save();
            }
            
            \DB::commit();
            return Response::json([], 200);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "status" => 1150,
                "error" => $e->getMessage()
            ], 404);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["status" => 1100], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reassignMembers(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "cwh_ids" => "array|required",
                // "date_end" => "required",
                "branch_id" => "required",
                "brand_id" => "required",
                "position_id" => "required",
                // "new_date_end" => "required",
                "new_date_start" => "required",
                "new_employment_status_id" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            foreach ($request->cwh_ids as $cwh_id) {
                $bwh = \DB::table("branch_work_histories")
                            ->where("client_work_history_id", $cwh_id)
                            ->orderBy("id", "DESC")
                            ->first();

                if (is_null($bwh)) {
                    //else create a new record with a new set of data
                    $bwh = new BranchWorkHistory;
                    $bwh->branch_id = $request->branch_id;
                    $bwh->position_id = $request->position_id;
                    $bwh->date_start = $request->new_date_start;
                    $bwh->date_end = $request->new_date_end;
                    $bwh->client_work_history_id = $cwh_id;
                    $bwh->employment_status_id = $request->new_employment_status_id;
                    $bwh->save();
                } else {
                    // if bwh exists, update date_end, reason_for_leaving, and remarks
                    $current_bwh = BranchWorkHistory::findOrFail($bwh->id);
                    $current_bwh->date_end = !is_null($request->date_end) ? $request->date_end : $request->new_date_start;
                    $current_bwh->reason_id = $request->reason_id;
                    $current_bwh->reason_for_leaving_remarks = $request->remarks;
                    $current_bwh->save();

                    $new_bwh = new BranchWorkHistory;
                    $new_bwh->branch_id = $request->branch_id;
                    $new_bwh->position_id = $request->position_id;
                    $new_bwh->date_start = $request->new_date_start;
                    $new_bwh->date_end = $request->new_date_end;
                    $new_bwh->client_work_history_id = $cwh_id;
                    $new_bwh->employment_status_id = $request->new_employment_status_id;
                    $new_bwh->save();
                }
            }

            return Response::json([], 200);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1150], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function updateStatus(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "bwh_ids" => "array|required",
                "employment_status_id" => "required",
                "date_start" => "required",
                "last_modified_by" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json(["status" => 1000], 422);
            }

            foreach ($request->bwh_ids as $bwh) {
                $bwh = BranchWorkHistory::findOrFail($bwh);
                $bwh->date_end = $request->date_start;
                $bwh->save();

                $new_bwh = new BranchWorkHistory;
                $new_bwh->enabled = 1;
                $new_bwh->position_id = $bwh->position_id;
                $new_bwh->branch_id = $bwh->branch_id;
                $new_bwh->client_work_history_id = $bwh->client_work_history_id;
                $new_bwh->date_start = $request->date_start;
                $new_bwh->date_end = $request->date_end;
                $new_bwh->last_modified_by = $request->last_modified_by;
                $new_bwh->employmentStatus()->associate($request->employment_status_id);
                $new_bwh->save();
                \DB::commit();
            }

            return Response::json([], 200);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Member in branch not found.",
                "status" => 1150
            ], 404);
        }
    }
}
