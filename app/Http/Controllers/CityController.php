<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Validator;
use App\Models\City;
use App\Models\Region;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = City::orderBy('city_name')->where('enabled', 1)->get();
        return Response::json(['data' => CityResource::collection($result)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query("page") ? $request->query("page") : 1;
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $selectedFields = $this->selectFields($request->query("fields"));
    
            if (strpos($request->query('_sort'), "region")) {
                array_push($selectedFields, "region_name");
            }
    
            $city = City::select($selectedFields);
    
            // filter
            if (gettype($request->query("region")) === "string") {
                $city = City::filter($selectedFields, $request->query("region"));
            }

            if ($request->query('enabled') != '') {
                $enabled = $request->query('enabled');
                $city = $city->where('enabled', $enabled)->select($selectedFields);
            }
            
            // sort
            if ($request->query("_sort")) {
                $city = $this->sort($city, $request->query("_sort"));
            }
    
            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $city = $city->where("city_name", "LIKE", "%$keyword%")
                    ->orWhere("id", "=", "$keyword")
                    ->orWhereHas("region", function ($query) use ($keyword) {
                        return $query->where("region_name", "LIKE", "%$keyword%");
                    });
            }
    
            return CityResource::collection($city->paginate($limit, $page));
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
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "city_name" => "required",
                "enabled" => "required",
                "last_modified_by" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000],
                422);
            }

            $region = Region::findOrFail($request->region_id);
            $city = $region->cities()->create($request->all());

            if ($city) {
                \DB::commit();
                return Response::json(new CityResource($city), 201);
            }

            return Response::json([
                "error" => "Server Error.",
                "status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["status" => 1151 ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "City not found.",
                "status" => 1155],
            404);
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
            $city = City::findOrFail($id);
            return Response::json(new CityResource($city));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error",
                "status" => 1100],
            500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "City not found.",
                "status" => 1150],
            404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $region = Region::findOrFail($request->region_id);
            $city = City::findOrFail($id);

            $validator = Validator::make($request->all(), [
                "city_name" => "required",
                "enabled" => "required",
                "last_modified_by" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000], 422);
            }
            
            $new_region_id = $request->region_id ? $request->region_id : $region;

            $city->fill($request->all());
            $city->region()->associate($new_region_id);

            if ($city->save()) {
                \DB::commit();
                return new CityResource($city);
            };

            return Response::json(["status" => 1152, 500]);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "City not found.",
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
            $result = City::findOrFail($id);

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
            \DB::rollback();
            return Response::json([
                "error" => "City not found.",
                "status" => 1150
            ], 404);
        }
    }

    /**
     * Sorts the list of resouce
     *
     * @param Illuminate\Database\Eloquent\Builder
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function sort($city, $sort)
    {
        $sort = explode(",", $sort);
        
        foreach ($sort as $key => $value) {
            $order = "ASC";
            if ($value[0] === "-") {
                $value = str_replace("-", "", $value);
                $order = "DESC";
            }

            if ($value == "region") {
                $city = $city->rightJoin("regions", "cities.region_id", "=", "regions.id")
                             ->orderBy("region_name", $order);
            } else {
                $city = $city->orderBy($value, $order);
            }
        }

        return $city;
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
            "cities.id",
            "city_name",
            "cities.enabled",
            "cities.last_modified_by",
            "region_id",
        ];
        
        $selected = [];

        if ($fields) {
            $queryFields = explode(",", $fields);
            foreach ($queryFields as $query) {
                if (in_array($query, $defaultFields)) {
                    array_push($selected, $query);
                }
            }
        }
        return (count($selected) > 0) ? $selected : $default;
    }
}
