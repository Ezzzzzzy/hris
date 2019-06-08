<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

use App\Models\EmploymentStatus;
use App\Http\Resources\EmploymentStatusResource;

class EmploymentStatusController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = EmploymentStatus::orderBy('status_name')->where('enabled', 1)->get();
        return Response::json(['data' => EmploymentStatusResource::collection($result)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query("page") ? $request->query("page") : 1;
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $selectedFields = $this->selectFields($request->query("fields"));
            $result = EmploymentStatus::select($selectedFields);

            // filter
            if (gettype($request->query("enabled")) === "string") {
                $result = EmploymentStatus::filter($selectedFields, $request->query("enabled"));
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("status_name", "LIKE", "%$keyword%")
                                 ->orWhere('id', $keyword);
            }

            return EmploymentStatusResource::collection($result->paginate($limit, $page));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "status_name" => "required|unique:employment_statuses,deleted_at,NULL|max:60",
                "color" => "required",
                "order" => "required",
                "type" => "required",
                "enabled" => "required",
                "last_modified_by" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $status = EmploymentStatus::create($request->all());
            
            if ($status) {
                \DB::commit();
                return Response::json(new EmploymentStatusResource($status), 201);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Facades\Response
     */
    public function show($id)
    {
        try {
            $result = EmploymentStatus::findOrFail($id);
            return new EmploymentStatusResource($result);
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Status not found.",
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
            $result = EmploymentStatus::findOrFail($id);

            $validator = Validator::make($request->all(), [
                "status_name" => [
                    "required",
                    "max:60",
                    Rule::unique("employment_statuses")->ignore($result->id),
                ],
                "color" => "required",
                "order" => "required",
                "last_modified_by" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $result->fill($request->all());

            if ($result->save()) {
                \DB::commit();
                return new EmploymentStatusResource($result);
            };

            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Status not found.",
                "status" => 1155
            ], 404);
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
        \DB::beginTransaction();
        try {
            $result = EmploymentStatus::findOrFail($id);
            
            if ($result->delete()) {
                \DB::rollback();
                return Response::json(['id' => (int) $id]);
            }

            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Status not found.",
                "status" => 1155
            ], 404);
        }
    }

    /**
     * Sorts the Collection
     *
     * @param Illuminate\Database\Eloquent\Builder $result
     * @param string $sort
     * @return Illuminate\Database\Eloquent\Builder $result
     */
    private function sort($result, $sort)
    {
        $sort = explode(",", $sort);
        foreach ($sort as $key => $value) {
            $order = "ASC";
            
            if ($value[0] === "-") {
                $value = str_replace("-", "", $value);
                $order = "DESC";
            }

            $result = $result->orderBy($value, $order);
        }

        return $result;
    }

    /**
     * Filters the collection of only selected fields
     *
     * @param string $fields
     * @return array
     */
    private function selectFields($fields)
    {
        $default = [
            "id",
            "status_name",
            "color",
            "type",
            "order",
            "enabled",
            "last_modified_by",
        ];
    
        $selected = [];

        if ($fields) {
            $queryFields = explode(",", $fields);
            foreach ($queryFields as $q) {
                if (in_array($q, $default)) {
                    array_push($selected, $q);
                }
            }
        }

        return (count($selected) > 0) ? $selected : $default;
    }
}
