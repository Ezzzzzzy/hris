<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Region;
use App\Http\Resources\RegionResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = Region::orderBy("region_name")->where("enabled", 1)->get();
        return Response::json(["data" => RegionResource::collection($result)]);
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
            $result = Region::select($selectedFields);
            
            // filter
            if (gettype($request->query("enabled")) === "string") {
                $result = Region::filter($selectedFields, $request->query("enabled"));
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("region_name", "LIKE", "%$keyword%")
                                 ->orWhere("id", $keyword);
            }

            return RegionResource::collection($result->paginate($limit, $page));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
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
        try {
            $validator = Validator::make($request->all(), [
                "region_name" => "required",
                "order" => "required",
                "enabled" => "required",
                "last_modified_by" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $result = Region::create($request->all());

            if ($result) {
                \DB::commit();
                return Response::json(new RegionResource($result), 201);
            }
            
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
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
            $result = Region::findOrFail($id);
            return new RegionResource($result);
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Region not found.",
                "status" => 1155],
            404);
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
            $result = Region::findOrFail($id);

            $validator = Validator::make($request->all(), [
                "region_name" => "required",
                "order" => "required",
                "last_modified_by" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000],
                422);
            }
            
            $result->fill($request->all());

            if ($result->save()) {
                \DB::commit();
                return Response::json(new RegionResource($result), 200);
            }

            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Region not found.",
                "status" => 1155],
            404);
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
            $result = Region::findOrFail($id);

            if ($result->delete()) {
                \DB::commit();
                return Response::json(["id" => (int) $id]);
            }

            return Response::json(["status" => 1100], 1100);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Region not found.",
                "status" => 1155],
            404);
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
            "region_name",
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
