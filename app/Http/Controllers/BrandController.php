<?php

namespace App\Http\Controllers;

use Excel;
use Validator;
use Carbon\Carbon;

use App\Models\Brand;
use App\Models\BusinessUnit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BrandController extends Controller
{
    public function fetchAll()
    {
        $result = Brand::where('enabled', 1)->get();

        return Response::json(['data' => $result]);
    }

    public function uploadBrands(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "import_file" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "status" => 1000,
                    "error" => $validator->errors()->first()
                ], 422);
            }

            $path = $request->file("import_file")->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            
            $curr_client = "PEOPLESERVE";
            $curr_business_unit = null;
            $check_curr_values = collect([]);

            $errors = collect([]);

            $rows = $data
            ->unique()
            ->map(function ($item) use (&$curr_client, &$curr_business_unit) {
                $curr_client = is_null($item['client_name']) ? $curr_client : $item['client_name'];
                $curr_business_unit = is_null($item['business_unit_name']) ? $curr_business_unit : $item['business_unit_name'];

                // check if $item['business_unit'] is under $curr_client
                $check_curr_bu = Client::where('client_name', $curr_client)
                ->first()
                ->businessUnits
                ->where('business_unit_name', $curr_business_unit)
                ->first();
                
                if (is_null($check_curr_bu)) {
                    $curr_business_unit = null;
                }

                $bu = BusinessUnit::where('business_unit_name', $curr_business_unit)->first();

                return [
                    "client_id" => Client::where('client_name', $curr_client)->first()->id,
                    "business_unit_id" => !is_null($bu) ? $bu->id : null,
                    "brand_name" => $item['brand_name'],
                    "enabled" => 1,
                    "last_modified_by" => "Admin"
                ];
            })
            ->filter(function ($item, $key) use ($errors) {
                $row_number = 'ROW #' . ($key + 2) . ': ';
                $required_fields = ['brand_name', 'client_id'];

                // filter if brand_name is already existing
                $check_brand = Brand::where('brand_name', $item['brand_name'])->first();
                if ($check_brand) {
                    $errors->push($row_number . ' SKIPPED - ' . $item['brand_name'] . ' already exists');
                    return ;
                }

                // filter if brand_name and client_id from map - array is empty
                foreach ($required_fields as $field) {
                    if (is_null($item[$field])) {
                        $errors->push($row_number . 'SKIPPED - has no ' . $field);
                        return ;
                    }
                }

                return $item;
            })
            ->each(function ($item, $key) {
                Brand::create($item);
            })
            ->values();

            \DB::commit();
            return Response::json([
                "errors" => $errors,
                "data" => $rows->count() . " row(s) inserted.",
            ]);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "status" => 1150,
                "error" => $e->getMessage(),
            ], 500);
        }
    }
}
