<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DisciplinaryAction;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\BranchWorkHistory;
use App\Http\Resources\DisciplinaryActionResource;
use DB;
use Validator;

class DisciplinaryActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $bwh_id)
    {
        try {
            $bwh = BranchWorkHistory::findOrFail($bwh_id);
            $disciplinaryActions = $bwh->disciplinaryActions;

            return Response::json(["disciplinary_actions" => $disciplinaryActions]);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bwh_id)
    {
        $validator = Validator::make($request->all(), [
            "date_of_incident" => "required",
            "incident_report" => "required",
            "date_of_notice_to_explain" => "required",
            "date_of_explanation" => "required",
            "date_of_decision" => "required",
            "status" => "required",
        ]);

        if ($validator->fails()) {
            return Response::json([
                "status" => 1000,
                "errors" => $validator->errors()->first()
            ], 422);
        }

        \DB::beginTransaction();
        try {
            $result = new DisciplinaryAction();
            if ($result->create($bwh_id, $request->all())) {
                \DB::commit();
                return Response::json(new DisciplinaryActionResource($result), 201);
            }

            return Response::json(["status" => 1152], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["status" => 1100], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json(["status" => 1150], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bwh_id, $da_id)
    {
        try {
            $result = DisciplinaryAction::findOrFail($da_id);
            return new DisciplinaryActionResource($result);
        } catch (QueryException $e) {
            return Response::json([
                "status" => 1100,
                "errors" => $e->getMessage()
            ], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json([
                "status" => 1155,
                "errors" => $e->getMessage()
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
    public function update(Request $request, $bwh_id, $da_id)
    {
        try {
            $bwh = BranchWorkHistory::findOrFail($bwh_id);
            $exists = $bwh->disciplinaryActions->contains($da_id);
            
            if ($exists) {
                $result = DisciplinaryAction::findOrFail($da_id);
                $validator = Validator::make($request->all(), [
                    "date_of_incident" => "required",
                    "incident_report" => "required",
                    "date_of_notice_to_explain" => "required",
                    "date_of_explanation" => "required",
                    "date_of_decision" => "required",
                    "status" => "required",
                ]);
    
                if ($validator->fails()) {
                    return Response::json([
                        "status" => 1000,
                        "errors" => $validator->errors()->first()
                    ], 422);
                }
    
                $result->fill($request->all());
                if ($result->save()) {
                    return Response::json([], 200);
                }
            }

            return Response::json(["status" => 1152], 500);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1150], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bwh_id, $da_id)
    {
        try {
            $bwh = BranchWorkHistory::findOrFail($bwh_id);
            $exists = $bwh->disciplinaryActions->contains($da_id);
            if ($exists) {
                $result = DisciplinaryAction::findOrFail($da_id);
                if ($result->delete()) {
                    return Response::json([], 204);
                }
            }
            
            return Response::json(["status" => 1154], 500);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1150], 404);
        }
    }
}
