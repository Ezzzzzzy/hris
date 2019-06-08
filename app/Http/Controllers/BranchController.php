<?php

namespace App\Http\Controllers;

use Excel;
use Validator;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;

use App\Classes\Paginate;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Region;
use App\Models\City;
use App\Models\Location;
use App\Http\Resources\BranchResource;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $result = Branch::getBranches($id, $request->query());
            
            return BranchResource::collection($result);
        } catch (\Illuminate\Database\Eloquent\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1150, 'errors' => 'Client not found.'], 404);
        };
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
                'branch_name' => 'required|unique:branches',
                'location_id' => 'required|numeric',
                'brand_id' => 'required|numeric',
                'enabled' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $result = Branch::create($request->all());
            
            \DB::commit();

            return new BranchResource($result, 201);
        } catch (\Illuminate\Database\Eloquent\QueryException $e) {
            \DB::rollback();
            return response()->json(['status' => 1100], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cli_id, $branch_id)
    {
        try {
            $client = Client::findOrFail($cli_id);

            $branch = Branch::findOrFail($branch_id);

            $result = Branch::whereHas('brand', function ($q) use ($client) {
                $q->where('client_id', $client->id);
            })->where('id', $branch_id)->first();

            // $hello = $client->whereHas('brands.branches', function ($q) use ($branch_id) {
            //     $q->where('branch_id', $branch_id);
            // })->get();

            // return Response::json(['data' => $result]);
            // return $client->with("brands.branches")->get();

            // check if branch belongs to client
            // if ($) {
            //     return Response::json([
            //         'status' => ,
            //         'errors' =>
            //     ]);
            // }

            // $branch = Branch::findOrFail($branch_id);
            
            return new BranchResource($result);
        } catch (\Illuminate\Database\Eloquent\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cli_id, $branch_id)
    {
        try {
            \DB::beginTransaction();

            $branch = Branch::findOrFail($branch_id);
            $validator = Validator::make($request->all(), [
                'branch_name' => [
                    'required',
                    Rule::unique('branches')->ignore($branch->id),
                ],
                'location_id' => 'required',
                'brand_id' => 'required',
                'enabled' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return Response::json(['status' => 1000], 422);
            }

            $branch->fill($request->all());

            if ($branch->save()) {
                \DB::commit();
                return Response::json([], 200);
            }

            return Response::json(['status' => 1152], 500);
        } catch (Illuminate\Database\Eloquent\QueryException $e) {
            \DB::rollback();
            
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cli_id, $branch_id)
    {
        try {
            $result = Branch::findOrFail($branch_id);
            
            if ($result->delete()) {
                return Response::json([], 204);
            }

            return Response::json(['status' => 1154], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
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
        $sort = explode(',', $sort);
        foreach ($sort as $key => $value) {
            if ($value[0] === '-') {
                $value = str_replace('-', '', $value);
                return $result->sortByDesc($value)->values();
            } else {
                return $result->sortBy($value)->values();
            }
        }
    }

    public function uploadBranches(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'import_file' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'error' => $validator->errors()->first()
                ], 422);
            }

            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            
            $errors = collect([]);

            $regions = $data
            ->unique()
            ->each(function ($item) {
                // check if exists
                $check_region = Region::where('region_name', $item['region_name'])->get()->count();
                if ($check_region <= 0) {
                    $region = new Region;
                    $region->region_name = ucfirst($item['region_name']);
                    $region->last_modified_by = 'Admin';
                    $region->enabled = 1;
                    $region->save();
                }

                $cities = Region::where('region_name', $item['region_name'])->first()->cities;
                $check_city_in_region = $cities->where('city_name', $item['city_name'])->count();
                if ($check_city_in_region <= 0) {
                    $city = new City;
                    $city->region_id = Region::where('region_name', $item['region_name'])->first()->id;
                    $city->city_name = ucfirst($item['city_name']);
                    $city->last_modified_by = 'Admin';
                    $city->enabled = 1;
                    $city->save();
                }

                $region_cities = Region::where('region_name', $item['region_name'])->first()->cities;
                $city_locations = $region_cities->where('city_name', $item['city_name'])->first()->locations;
                $check_location = $city_locations->where('location_name', $item['location_name'])->count();
                if ($check_location <= 0) {
                    $location = new Location;
                    $location->city_id = $region_cities->where('city_name', $item['city_name'])->first()->id;
                    $location->location_name = ucfirst($item['location_name']);
                    $location->enabled = 1;
                    $location->last_modified_by = 'Admin';
                    $location->save();
                }
            });
            \DB::commit();

            $rows = $data
            ->unique()
            ->filter(function ($item, $key) use ($errors) {
                $row_number = 'ROW #' . ($key+2) . ': ';
                $headers = $item->keys()->all();

                foreach ($headers as $header) {
                    if (is_null($item[$header]) || $item[$header] === '') {
                        $errors->push($row_number . ' has no' . $header);
                        return ;
                    }
                }

                // check if brand exists
                $check = Brand::where('brand_name', $item['brand_name'])->first();

                if (is_null($check)) {
                    $errors->push($row_number . 'Brand: '. $item['brand_name'] . ' does not exist');
                    return ;
                }

                $check_branches = $check->branches->where('branch_name', $item['branch_name'])->values()->count();
                if ($check_branches > 0) {
                    $errors->push($row_number . $item['branch_name'] . ' already exists in ' . $item['brand_name']);
                    return ;
                }
                
                return $item;
            })
            ->map(function ($item, $key) {
                return [
                    'brand_id' => Brand::where('brand_name', $item['brand_name'])->first()->id,
                    'location_id' => Region::where('region_name', $item['region_name'])->with(['cities','cities.locations'])->first()
                                    ->cities->where('city_name', $item['city_name'])->first()
                                    ->locations->where('location_name', $item['location_name'])->first()
                                    ->id,
                    'branch_name' => ucfirst($item['branch_name']),
                    'enabled' => 1,
                    'last_modified_by' => 'Admin',
                ];
            })
            ->each(function ($item, $key) {
                $result = new Branch;
                $result->fill($item);
                $result->save();
            });

            \DB::commit();
            return Response::json([
                'errors' => $errors,
                'data' => $rows->count() . ' rows(s) inserted.',
            ]);
        } catch (\Illuminate\Database\Eloquent\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1150,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
