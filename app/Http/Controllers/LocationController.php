<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\City;
use App\Models\Location;
use App\Models\Region;
use App\Http\Resources\LocationResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = Location::orderBy('location_name')->where('enabled', 1)->get();
        return Response::json(['data' => LocationResource::collection($result)]);
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
            $filter = $this->getCitiesByRegions($request->query("regions"));

            if (strpos($request->_sort, 'city') !== false) {
                array_push($selectedFields, "city.city_name");
            }
            if (strpos($request->_sort, 'region') !== false) {
                array_push($selectedFields, "region.region_name");
            }

            $result = Location::select($selectedFields);

            // filter
            if (count($filter) > 0) {
                $result = Location::filter($selectedFields, $filter);
            }

            if ($request->enabled != '') {
                $result = $result->where('enabled', '=', $request->enabled);
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("location_name", "LIKE", "%$keyword%")
                    ->orWhere("id", "=", "$keyword")
                    ->orWhereHas("city", function ($query) use ($keyword) {
                        return $query->where("city_name", "LIKE", "%$keyword%");
                    })
                    ->orWhereHas("city.region", function ($query) use ($keyword) {
                        return $query->where("region_name", "LIKE", "%$keyword%");
                    });
            }

            return LocationResource::collection($result->paginate($limit, $page));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server error.",
                "status" => $e
            ], 500);
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
                "location_name" => "required",
                "enabled" => "required",
                "last_modified_by" => "required",
                "city_id" => "required"
            ]);
    
            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $result = Location::create($request->all());

            if ($result) {
                \DB::commit();
                return Response::json(new LocationResource($result), 201);
            }
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
            $result = Location::findOrFail($id);
            return Response::json(new LocationResource($result), 201);
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Location not found.",
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
            $result = Location::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                "location_name" => "required",
                "last_modified_by" => "required",
                "city_id" => "required"
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
                return new LocationResource($result);
            }
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Location not found.",
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
            $result = location::findOrFail($id);
            
            if ($result->delete()) {
                \DB::commit();
                return Response::json(['id' => (int) $id]);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Location not found.",
                "status" => 1155
            ], 404);
        }
    }

    private function getCitiesByRegions($regions)
    {
        $filter = [];

        if ($regions) {
            $queryFilter = explode(",", $regions);
            foreach ($queryFilter as $q) {
                array_push($filter, $q);
            }
        }

        return $filter;
    }

    private function sort($result, $sort)
    {
        $sort = explode(",", $sort);
        foreach ($sort as $key => $value) {
            $order = "ASC";
            if ($value[0] === "-") {
                $value = str_replace("-", "", $value);
                $order = "DESC";
            }

            if ($value == "city") {
                $result = $result->leftJoin("cities as city", "locations.city_id", '=', 'city.id')
                ->orderBy('city.city_name', $order);
            } elseif ($value == "region") {
                $result = $result->join("cities", "locations.city_id", '=', 'cities.id')
                    ->join("regions as region", "cities.region_id", "=", "region.id")
                    ->orderBy('region.region_name', $order);
            } else {
                $result = $result->orderBy($value, $order);
            }
        }
        return $result;
    }

    private function selectFields($fields)
    {
        $default = [
            "locations.id",
            "location_name",
            "locations.enabled",
            "locations.last_modified_by",
            "city_id",
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

    private function filter($array, $filters)
    {
        $filteredArray = [];
        foreach ($filters as $filter) {
            foreach ($array as $item) {
                if ($item->city->region->id == $filter) {
                    array_push($filteredArray, $item);
                }
            }
        }
        return $filteredArray;
    }

    private function search($array, $key, $key2, $keyword)
    {
        $collection = collect($array)->filter(function ($item) use ($keyword, $key, $key2) {
            return $item->id == $keyword
                ? $item
                : stristr($item->city->city_name, $keyword) || stristr($item->city->region->region_name, $keyword);
        });
        return $collection;
    }
}
