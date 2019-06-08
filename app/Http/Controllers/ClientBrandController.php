<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;

use App\Classes\Paginate;
use App\Models\Brand;
use App\Models\Client;
use App\Models\BusinessUnit;
use App\Http\Resources\ClientBrandResource;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ClientBrandController extends Controller
{
    public function index(Request $request, $client_id)
    {
        try {
            $client = Client::findOrFail($client_id);
            $result = Brand::getBrands($client_id, $request->query());

            return ClientBrandResource::collection($result);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json([
                'status' => 1100,
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'status' => 1155,
                'errors' => 'Client not found.'
            ], 404);
        }
    }

    public function store(Request $request, $cli_id)
    {
        \DB::beginTransaction();
        try {
            $client = Client::findOrFail($cli_id);

            $validator = Validator::make($request->all(), [
                'brand_name' => 'required|unique:brands',
                'enabled' => 'required',
                'last_modified_by' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'error' => $validator->errors()->first(),
                    'status' => 1000
                ], 422);
            }
            
            // check if business unit exists
            if (!empty($request->business_unit_id)) {
                $bu = BusinessUnit::findOrFail($request->business_unit_id);
            }

            // check if business unit belongs to given client
            $check_client_bu = null;
            if (!empty($bu)) {
                $check_client_bu = $client->businessUnits->where('id', $bu->id)->first();
            }

            $result = Brand::create(array_merge($request->all(), [
                'client_id' => $cli_id,
                'business_unit_id' => is_null($check_client_bu) ? null : $bu->id
            ]));

            \DB::commit();
            return new ClientBrandResource($result, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1150,
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'status' => 1155,
                'errors' => 'Client not found'
            ]);
        }
    }

    public function show(Request $request, $cli_id, $brand_id)
    {
        try {
            $client = Client::findOrFail($cli_id);

            // check if brand_id is in client
            if (!$client->brands->contains('id', $brand_id)) {
                return Response::json([
                    'status' => 1155,
                    'errors' => 'Brand does not belong to Client',
                ]);
            }

            $result = Brand::findOrFail($brand_id);

            return new ClientBrandResource($result);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'status' => 1155,
                'errors' => "Brand not found."
            ], 404);
        }
    }

    public function update(Request $request, $client_id, $brand_id)
    {
        \DB::beginTransaction();
        try {
            $client = Client::findOrFail($client_id);
            $brand = Brand::findOrFail($brand_id);

            $validator = Validator::make($request->all(), [
                'brand_name' => [
                    'required',
                    Rule::unique('brands')->ignore($brand->id),
                ],
                'enabled' => 'required',
                'last_modified_by' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            // check if brand belongs to client
            if (!$client->brands->contains('id', $brand_id)) {
                return Response::json([
                    'status' => 1000,
                    'errors' => 'Brand does not belong to Client'
                ]);
            }

            $brand->update($request->all());

            \DB::commit();

            return Response::json();
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155], 404);
        }
    }

    public function destroy($cli_id, $brand_id)
    {
        \DB::beginTransaction();
        try {
            $client = Client::findOrFail($cli_id);
            
            // check if brand belongs to client
            if (!$client->brands->contains($brand_id)) {
                return Response::json([
                    'status' => 1000,
                    'errors' => 'Brand does not belong to Client'
                ]);
            }

            $result = Brand::findOrFail($brand_id);
            $result->delete();

            \DB::commit();

            return Response::json(204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155, 'errors' => $e->getMessage()], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        }
    }

    private function search($result, $keyword)
    {
        return $result->filter(function ($item) use ($keyword) {
            return false !== (stristr($item['brand_name'], $keyword));
        })->values();
    }

    public function members(Request $request, $id, $brand_id)
    {
        try {
            $limit = $request->query('limit') ? $request->query('limit') : 10;
            $page = $request->query('page') ? $request->query('page') : 1;
            $result = Brand::findOrFail($brand_id);
            $result = $result->getMembers();

            $filter = ['position', 'location', 'status', 'gender'];

            if ($request->query()) {
                $str_queries = $request->query();

                if ($request->query('start') || $request->query('end')) {
                    $start = $request->query('start');
                    $end = $request->query('end') ? $request->query('end') : Carbon::now();
                    $result = $this->filterDate($result, $start, $end);
                }

                foreach ($str_queries as $key => $value) {
                    if (in_array($key, $filter)) {
                        if ($key === 'gender') {
                            if ($key === 'gender') {
                                $value = strtoupper($value);
                            }
                        } else {
                            $key = $key . '_id';
                        }
                        $result = $this->filter($result, $key, $value);
                    }
                }
            }

            // sort
            if ($request->query('_sort')) {
                $result = $this->sort($result, $request->query('_sort'));
            }

            // search
            if ($request->query('q')) {
                $keyword = $request->query('q');
                $result = $this->search($result, $keyword);
            }

            $result = new Paginate(collect($result)->values(), $page, $limit);
            return $result::paginate();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => $e->getMessage()], 500);
        }
    }

    private function sort($result, $sort)
    {
        $sort = explode(',', $sort);
        foreach ($sort as $key => $value) {
            if ($value[0] === '-') {
                $value = str_replace('-', '', $value);
                $result = $result->sortByDesc(function ($col) use ($value) {
                    if ($value === 'date_start') {
                        return Carbon::parse($col['date_start']);
                    } else {
                        return $col[$value];
                    }
                });
            } else {
                $result = $result->sortBy(function ($col) use ($value) {
                    if ($value === 'date_start') {
                        return Carbon::parse($col['date_start']);
                    } else {
                        return $col[$value];
                    }
                });
            }
        }

        return $result->values();
    }
    
    public function all(Request $request, $id)
    {
        try {
            $result = Client::findOrFail($id);
            $result = $result->getBrands();

            return Response::json(['data' => $result]);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => $e], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155], 404);
        }
    }
    
    public function getBranches(Request $request, $cli_id, $brand_id)
    {
        try {
            $brand = Brand::findOrFail($brand_id);
            $branches = $brand->branches;

            $result = $branches->map(function ($item) {
                return [
                    'id' => $item->id,
                    'branch_name' => $item->branch_name,
                    'last_modified_by' => $item->last_modified_by,
                    'location_id' => $item->location_id
                ];
            });

            return Response::json(['data' => $result]);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => $e], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155], 404);
        }
    }

    private function selectFields($fields)
    {
        $default = [
            'id',
            'brand_name',
            'enabled',
            'business_unit_id',
            'last_modified_by'
        ];

        $selected = [];

        if ($fields) {
            $queryFields = explode(',', $fields);
            foreach ($queryFields as $q) {
                if (in_array($q, $default)) {
                    array_push($selected, $q);
                }
            }
        }

        return (count($selected) > 0) ? $selected : $default;
    }

    private function filter($result, $key, $filter)
    {
        return $result->where($key, $filter)->values();
    }

    private function filterDate($result, $start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        return $result->filter(function ($item) use ($start, $end) {
            $date_start = Carbon::parse($item['date_start']);
            if ($date_start->between($start, $end)) {
                return $item;
            }
        })->values();
    }
}
