<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

use App\Models\Reason;
use App\Http\Requests\ReasonRequest;
use App\Http\Resources\ReasonResource;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = Reason::orderBy('reason')->where('enabled', 1)->get();
        return Response::json(['data' => ReasonResource::collection($result)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Support\Facades\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $page = $request->query("page") ? $request->query("page") : 1;
            $selectedFields = $this->selectFields($request->query("fields"));
            $result = Reason::select($selectedFields);

            // filter
            if (gettype($request->query("enabled")) === "string") {
                $result = Reason::filter($selectedFields, $request->query("enabled"));
            }

            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("reason", "LIKE", "%$keyword%")
                                 ->orWhere("id", $keyword);
            }

            return ReasonResource::collection($result->paginate($limit));
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
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
            $validator= Validator::make($request->all(), [
                "reason" => "required",
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
            
            $result = Reason::create($request->all());

            if ($result) {
                \DB::commit();
                return new ReasonResource($result, 201);
            }
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Facades\Response
     */
    public function show(Reason $reason, $id)
    {
        try {
            $result = Reason::findOrFail($id);
            return new ReasonResource($result);
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Reason not found.",
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
            $result = Reason::findOrFail($id);

            $validator = Validator::make($request->all(), [
                "reason" => [
                    "required",
                    Rule::unique("reasons")->ignore($result->id),
                ],
                "order" => "required",
                "last_modified_by" => "required"
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
                return new ReasonResource($result, 200);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Reason not found.",
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
            $result = Reason::findOrFail($id);

            if ($result->delete()) {
                \DB::commit();
                return Response::json(['id' => (int) $id]);
            }

            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "Reason not found.",
                "status" => 1155
            ], 404);
        }
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
            "reason",
            "order",
            "enabled",
            "last_modified_by"
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
}
