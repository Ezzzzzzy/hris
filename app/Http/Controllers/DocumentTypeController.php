<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

use App\Models\DocumentType;
use App\Http\Requests\DocumentTypeRequest;
use App\Http\Resources\DocumentTypeResource;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource without pagination.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchAll(Request $request)
    {
        $result = DocumentType::orderBy('type_name')->where('enabled', 1)->get();
        return Response::json(['data' => DocumentTypeResource::collection($result)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query("page") ? $request->query("limit") : 1;
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $selectedFields = $this->selectFields($request->query("fields"));
            $result = DocumentType::select($selectedFields);

            // filter
            if (gettype($request->query("enabled")) === "string") {
                $result = DocumentType::filter($selectedFields, $request->query("enabled"));
            }
            
            // sort
            if ($request->query("_sort")) {
                $result = $this->sort($result, $request->query("_sort"));
            }
            
            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $result->where("type_name", "LIKE", "%$keyword%")
                                    ->orWhere("id", $keyword);
            }

            return DocumentTypeResource::collection($result->paginate($limit, $page));
        } catch (QueryException $e) {
            return Response::json(["error" => $e->getMessage()]);
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100
            ],500);
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
                "type_name" => "required|unique:document_types",
                "order" => "required",
                "document_type" => "required",
                "enabled" => "required",
                "last_modified_by" => "required"
            ]);
    
            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000],
                422);
            }

            $status = DocumentType::create($request->all());

            if ($status) {
                \DB::commit();
                return Response::json(new DocumentTypeResource($status), 201);
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
            $result = DocumentType::findOrFail($id);
            return new DocumentTypeResource($result);
        } catch (QueryException $e) {
            return Response::json([
                "error" => "Server Error.",
                "status" => 1100],
            500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "error" => "Document not found.",
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
            $result = DocumentType::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                "type_name" => [
                    "required",
                    Rule::unique("document_types")->ignore($result->id),
                ],
                "order" => "required",
                "document_type" => "required",
                "enabled" => "required",
                "last_modified_by" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000,],
                422);
            }

            $result->fill($request->all());

            if ($result->save()) {
                \DB::commit();
                return new DocumentTypeResource($result);
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
                "error" => "Document not found.",
                "status" => 1152],
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
            $result = DocumentType::findOrFail($id);
            
            if ($result->delete()) {
                \DB::commit();
                return Response::json(['id' => (int) $id]);
            };

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
                "error" => "Document not found.",
                "status" => 1155],
            404);
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
            "type_name",
            "document_type",
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
