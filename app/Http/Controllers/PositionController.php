<?php

namespace App\Http\Controllers;

use Excel;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Position;
use App\Http\Resources\PositionResource;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = Position::orderBy("position_name")->where("enabled", 1)->get();
        return Response::json(["data" => PositionResource::collection($result)]);
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
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $page = $request->query("page") ? $request->query("page") : 1;
            $selectedFields = $this->selectFields($request->query("fields"));
            $result = Position::select($selectedFields);

            // Filter if resource is enabled or not
            if (gettype($request->query("enabled")) === "string") {
                $result = Position::filter($selectedFields, $request->query("enabled"));
            }

            // Sort resource records according to given query parameter string
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // Search resource records by name or id
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("position_name", "LIKE", "%$keyword%")
                                 ->orWhere("id", $keyword);
            }

            return PositionResource::collection($result->paginate($limit));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        };
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
                "position_name" => "required|unique:positions",
                "order" => "required",
                "enabled" => "required",
                "last_modified_by" => "required",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            $result = Position::create($request->all());

            if ($result) {
                \DB::commit();
                return Response::json(new PositionResource($result), 201);
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
            $position = Position::findOrFail($id);
            return new PositionResource($position, 200);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Position not found.",
                "status" => 1150
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $result = Position::findOrFail($id);
            $validator = Validator::make($request->all(), [
                "position_name" => [
                    "required",
                    Rule::unique("positions")->ignore($result->id),
                ],
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
                return new PositionResource($result, 200);
            };

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Position not found.",
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
            $result = Position::findOrFail($id);

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
                "error" => "Position not found.",
                "status" => 1150
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
            "position_name",
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

    public function uploadPositions(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "import_file" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "status" => 1000,
                    "error" =>  $validator->errors()->first()
                ], 422);
            }

            $path = $request->file("import_file")->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();

            $errors = collect([]);
            $rows = $data
            ->unique()
            ->filter(function ($item, $key) use ($errors) {
                $row_number = "ROW #" . ($key+2) . ": ";
                $headers = $item->keys()->all();
                
                // check if row has empty cell
                if (is_null($item["position_name"]) || $item["position_name"] === "") {
                    $errors->push($row_number . " has no position_name");
                    return ;
                }

                // check if position_name already exists
                $check = Position::where("position_name", $item["position_name"])->get()->count();
                if ($check > 0) {
                    $errors->push($row_number . $item["position_name"] . " already exists");
                    return ;
                }
            
                return $item;
            })
            ->map(function ($item) {
                return [
                    "position_name" => ucfirst($item["position_name"]),
                    "last_modified_by" => "Admin",
                    "enabled" => 1,
                ];
            })
            ->each(function ($item) {
                $position = new Position;
                $position->fill($item);
                $position->save();
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
                "status" => 1100,
                "error" => $e->getMessage()
            ]);
        }
    }
}
