<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\TenureType;
use App\Http\Resources\TenureTypeResource;

use Validator;

class TenureTypeController extends Controller
{
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
            "tenure_type",
            "month_start_range",
            "month_end_range",
            "enabled"
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
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = TenureType::orderBy("tenure_type")->where("enabled", 1)->get();
        return Response::json(["data" => TenureTypeResource::collection($result)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $page = $request->query("page") ? $request->query("page") : 1;
            $selectedFields = $this->selectFields($request->query("fields"));
            $result = TenureType::select($selectedFields);

            // Filter resources by "enabled" attribute
            if (gettype($request->query("enabled")) === "string") {
                $result = TenureType::filter($selectedFields, $request->query("enabled"));
            }

            // Sort resources by the given user query
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // Search by tenure_type or by tenure_type ID
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("tenure_type", "LIKE", "%$keyword%")
                                 ->orWhere("id", $keyword);
            }

            return TenureTypeResource::collection($result->simplePaginate($limit));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server error.",
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
                "tenure_type" => "required",
                "month_start_range" => "required",
                "month_end_range" => "required",
                "enabled" => "required",
            ]);
    
            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $result = TenureType::create($request->all());

            if ($result) {
                \DB::commit();
                return new TenureTypeResource($result, 201);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
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
            $result = TenureType::findOrFail($id);
            return new TenureTypeResource($result, 200);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Tenure Type not found.",
                "status" => 1150
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
            $result = TenureType::findOrFail($id);
             
            $validator = Validator::make($request->all(), [
                "tenure_type" => "required",
                "month_start_range" => "required",
                "month_end_range" => "required",
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
                return new TenureTypeResource($result, 200);
            }
            
            return Response::json(["status" => 1152], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Tenure Type not found.",
                "status" => 1150
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
            $result = TenureType::findOrFail($id);

            if ($result->delete()) {
                \DB::commit();
                return Response::json(["id" => (int) $id]);
            }

            return Response::json(["status" => 1154], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Tenure Type not found.",
                "status" => 1150
            ], 404);
        }
    }
}
