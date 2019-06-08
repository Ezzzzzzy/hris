<?php

namespace App\Http\Controllers;

use Excel;
use Validator;
use Carbon\Carbon;

use App\Models\Client;
use App\Models\ClientWorkHistory;
use App\Models\Role as RoleModel;
use App\Classes\Paginate;
use App\Http\Resources\ClientResource;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            // modified
            // $selectedClients = $request->query('id');
            // $clients = $selectedClients ? explode(',', $selectedClients) : [];

            // $result = Client::getClients($clients, $request->query());

            // return ClientResource::collection($result);


            //// original ////
            $page = $request->query('page') ? $request->query('page') : 1;
            $limit = $request->query('limit') ? $request->query('limit') : 10;
            $selectedClients = $request->query('id');
            $clients = $selectedClients ? explode(',', $selectedClients) : 'all';

            if ($clients === 'all') {
                $result = Client::get();
            } else {
                $result = Client::whereIn('id', $clients)->get();
            }

            $result = $this->getCount($result);

            // filter
            if (gettype($request->query('enabled')) === 'string') {
                $enabled = (int) $request->query('enabled');
                $result = $this->filterEnabled($result, $enabled);
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

            $result = new Paginate(collect($result), $page, $limit);
            return $result::paginate();
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        }
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'client_name' => 'required|unique:clients',
                'code' => 'required|unique:clients',
                // 'contract_name' => 'unique:clients',
                'last_modified_by' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'errors' => $validator->errors()->first()
                ], 422);
            }
        
            $client = Client::create(
                array_merge($request->all(), [
                    'client_name' => ucfirst($request->client_name),
                    'code' => strtoupper($request->code),
                    'enabled' => 1
                ])
            );

            if ($client) {
                // add new client permission to admin
                $role = RoleModel::where('name', 'Admin')->first();
                $client_ids = $role->clients->map(function ($item) {
                    return $item->id;
                })->push($client->id)->all();
                $role->clients()->sync($client_ids);

                \DB::commit();
                return new ClientResource($client, 201);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            return Response::json([
                'status' => 1100,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client = $client
                        ->withCount([
                            'members',
                            'brandsWithoutBusinessUnit',
                            'brands',
                            'businessUnits',
                            'brands as branches_count' => function ($q) {
                                $q->join('branches', 'brands.id', 'branches.brand_id');
                                $q->where('branches.deleted_at', null);
                            }
                        ])
                        ->where('id', $id)
                        ->first();

            return new ClientResource($client);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155, 'errors' => "Client not found."], 404);
        }
    }

    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $client = Client::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'client_name' => [
                    'required',
                    Rule::unique('clients')->ignore($id),
                ],
                // 'contract_name' => [
                //     Rule::unique('clients')->ignore($id),
                // ],
                'code' => [
                    'required',
                    Rule::unique('clients')->ignore($id)
                ],
                'last_modified_by' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'errors' => $validator->errors()->first()
                ], 422);
            }
            
            $client->update(array_merge($request->all(), [
                'client_name' => ucfirst($request->client_name),
                'code' => strtoupper($request->code),
            ]));

            \DB::commit();
            return new ClientResource($client);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
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

    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            return Response::json([], 204);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json(['status' => 1155], 404);
        }
    }

    public function all()
    {
        // To Do
        // [ ] search in client all
        try {
            $result = Client::all();
            return Response::json(['data' => $result]);
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['status' => 1100]);
        }
    }

    private function sort($result, $sort)
    {
        $sort = explode(',', $sort);
        foreach ($sort as $key => $value) {
            $order = 'ASC';
            if ($value[0] === '-') {
                $value = str_replace('-', '', $value);
                $order = 'DESC';
            }
            $result = $result->orderBy($value, $order);
        }

        return $result;
    }

    public function getCount($clients)
    {
        $result = [];
        foreach ($clients as $client) {
            $res['id'] = $client->id;
            $res['name'] = $client->client_name;
            $res['contract_name'] = $client->contract_name;
            $res['code'] = $client->code;
            $res['enabled'] = $client->enabled;
            $res['last_modified'] = Carbon::parse($client->updated_at)->toFormattedDateString();
            $res['last_modified_by'] = $client->last_modified_by;
            $res['branches_count'] = $client->branches->count();
            $res['business_unit_count'] = $client->businessUnits->count();
            $res['brands_count'] = $client->brandsWithoutBusinessUnit->count(); //$client->brands->count();
            $res['members_count'] = $client->clientWorkHistory->filter(function ($item) {
                return is_null($item->date_end) || Carbon::parse($item->date_end)->isFuture();
            })->values()->count();
            
            $result[] = $res;
        }

        return collect($result);
    }

    public function filterEnabled($result, $enabled)
    {
        return $result->filter(function ($item) use ($enabled) {
            return $item['enabled'] === $enabled;
        })->values();
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
            return false !== (stristr($item['name'], $keyword) || stristr($item['code'], $keyword));
        })->values();
    }

    public function uploadClients(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make([
                'import_file' => $request->import_file,
                'extension' => $request->import_file->getClientOriginalExtension()
            ], [
                'import_file' => 'required',
                'extension' => "required|in:xlsx,xls',"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'status' => 1000,
                    'error' =>  $validator->errors()->first()
                ], 422);
            }

            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();

            $errors = collect([]);
            $rows = $data
            ->unique()
            ->filter(function ($item, $key) use ($errors) {
                $row_number = 'ROW #' . ($key+2) . ': ';
                $headers = $item->keys()->all();
                
                foreach ($headers as $header) {
                    // check if row has empty cell
                    if (is_null($item[$header]) || $item[$header] === '') {
                        $errors->push($row_number . ' has no ' . $header);
                        return ;
                    }

                    // check if client_name || code already exists
                    $check_if_exists = Client::where('client_name', $item[$header])->orWhere('code', $item[$header])->get()->count();
                    if ($check_if_exists > 0) {
                        $errors->push($row_number . $item[$header] . ' ' . $header .  ' already exists');
                        return ;
                    }
                }
            
                return $item;
            })
            ->map(function ($item) {
                $headers = $item->keys()->all();
                $new_headers = [];
                // match values if headers are inconsistent
                foreach ($headers as $header) {
                    $res['client_name'] = strpos($header, 'name') ? $item[$header] : null;
                    $res['code'] = strpos($header, 'code') ? $item[$header] : null;
                    $new_headers[] = $res;
                }

                return array_merge(array_filter($new_headers[1]), array_filter($new_headers[0]));
            })
            ->each(function ($item) {
                Client::create([
                    'client_name' => ucfirst($item['client_name']),
                    'code' => strtoupper($item['code']),
                    'enabled' => 1,
                    'last_modified_by' => 'Admin'
                ]);
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
                'status' => 1100,
                'error' => $e->getMessage()
            ]);
        }
    }
}
