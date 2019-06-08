<?php

namespace App\Http\Controllers;

use Excel;
use Validator;
use Carbon\Carbon;

use App\Models\Brand;
use App\Models\BusinessUnit;
use App\Models\Client;
use App\Models\ClientWorkHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BusinessUnitResource;
use App\Http\Resources\BusinessUnitsResource;

class BusinessUnitController extends Controller
{
    public function index(Request $request, $client_id)
    {
        try {
            $result = BusinessUnit::getBusinessUnits($client_id, $request->query());

            return BusinessUnitResource::collection($result);
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

    public function store(Request $request, $client_id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'business_unit_name' => 'required',
                'code' => 'required',
                'enabled' => 'required',
                'last_modified_by' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'errors' => $validator->errors()->first()
                ], 422);
            }
     
            $result = BusinessUnit::create(array_merge($request->all(), [
                'business_unit_name' => ucfirst($request->business_unit_name),
                'code' => strtoupper($request->code),
                'client_id' => $client_id
            ]));

            $result->save();
            \DB::commit();
            return new BusinessUnitResource($result, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1100,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show($client_id, $business_unit_id)
    {
        try {
            $result = BusinessUnit::where('client_id', $client_id)->findOrFail($business_unit_id);

            return new BusinessUnitResource($result);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json([
                'status' => 1150,
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'status' => 1155,
                'errors' => 'Business Unit not found.'
            ], 404);
        }
    }

    public function update(Request $request, $client_id, $bu_id)
    {
        \DB::beginTransaction();
        try {
            $result = BusinessUnit::where('client_id', $client_id)->findOrFail($bu_id);

            $validator = Validator::make($request->all(), [
                'business_unit_name' => 'required',
                'code' => 'required',
                'enabled' => 'required',
                'last_modified_by' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json(['status' => 1000], 422);
            }

            $result->update($request->all());
            \DB::commit();
            return Response::json();
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1100,
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'status' => 1150,
                'errors' => "Business Unit not found."
            ], 404);
        }
    }

    public function destroy($cli_id, $bu_id)
    {
        try {
            $cli_id = Client::findOrFail($cli_id);
            $belongsToClient = $cli_id->businessUnits->contains($bu_id);

            if ($belongsToClient) {
                $result = BusinessUnit::findOrFail($bu_id);
                if ($result->delete()) {
                    return Response::json([], 204);
                }
            }

            return Response::json(['status' => 1154], 500);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1150], 404);
        }
    }

    public function allPerClient(Request $request, $id)
    {
        try {
            $result = Client::findOrFail($id);
            return $result->getBusinessUnits();
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

    public function uploadBusinessUnits(Request $request)
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
            $data = Excel::load($path)->get();
            
            $errors = collect([]);

            $curr_client = "PEOPLESERVE";

            $rows = $data
            ->unique()
            ->filter(function ($item, $key) use ($errors, &$curr_client) {
                $row_number = 'ROW #' . ($key+2) . ': ';
                $headers = $item->keys()->all();

                $curr_client = (is_null($item['client_name']) || $item['client_name'] === "") ? $curr_client : $item['client_name'];

                // check if required fields are empty
                if (is_null($item['business_unit_name']) || $item['business_unit_code'] === "") {
                    $errors->push($row_number . 'SKIPPED - has no business_unit_name or business_unit_code');
                    return ;
                }

                // check if client_name exists
                $check_client = Client::where('client_name', $curr_client)->count();
                
                if ($check_client == 0) {
                    $errors->push($row_number . 'Client - "' . $item['client_name'] . '" does not exist');
                    return ;
                }

                // check if already exists
                $business_units = Client::where('client_name', $curr_client)->first()->businessUnits;

                foreach ($headers as $header) {
                    if (strpos($header, 'client_name')) {
                        continue;
                    }

                    $column = strpos($header, 'code') ? 'code' : $header;
                    $check = $business_units->where($column, $item[$header])->values()->count();
                    if ($check > 0) {
                        $errors->push($row_number .  $column  . ' '. $item[$header] . ' already exists in ' . $item['client_name']);
                        return ;
                    }
                }

                return $item;
            })
            ->map(function ($item) use (&$curr_client) {
                $curr_client = is_null($item['client_name']) ? $curr_client : $item['client_name'];
                $client = Client::where('client_name', $curr_client)
                                ->first();

                return [
                    'client_id' => $client->id,
                    'business_unit_name' => ucfirst($item['business_unit_name']),
                    'code' => strtoupper($item[$item->keys()->values()->filter(function ($item) {
                        return strpos($item, 'code');
                    })->first()]),
                    'last_modified_by' => 'Admin',
                    'enabled' => 1,
                ];
            })
            ->each(function ($item, $key) {
                BusinessUnit::create($item);
            })
            ->values();

            \DB::commit();
            return Response::json([
                'errors' => $errors,
                'data' => $rows->count() . ' row(s) inserted.',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1150,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
