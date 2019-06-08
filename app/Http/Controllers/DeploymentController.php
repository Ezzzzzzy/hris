<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Requests\DeploymentRequest;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\BranchWorkHistory;
use App\Http\Resources\DeploymentResource;
use App\Models\ClientWorkHistory;
use App\Models\EmploymentStatus;
use App\Models\Member;
use App\Models\Reason;

class DeploymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http response
     */
    public function storeMemberDeployment(Request $request, $member_id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "client_id" => "required",
                "branch_id" => "required",
                "brand_id" => "required",
                "position_id" => "required",
                "employee_id" => "required",
                "employment_status_id" => "required",
                "date_start" => "required",
                "last_modified_by" => "required"
            ]);

            if ($validator->fails()){
                return Response::json([
                    "status" => 1100,
                    "error" => $validator->errors()->first()
                ]);
            }
            
            $members = BranchWorkHistory::deployMember($request->all(), $member_id);

            if ($members) {
                \DB::commit();
                return Response::json([
                    'data' => $members
                ]);
            }
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(['status' => 1100], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json(['status' => $e->getMessage()], 404);
            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateMemberDeployment(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $member = BranchWorkHistory::updateStatusHistory($request->all());
            if ($member) {
                \DB::commit();
                return Response::json($member, 204);
            }
        } catch (QueryException $e) {
            \DB::rollback();

            return Response::json(['status' => 1100], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();

            return Response::json(['status' => 1150], 404);
        }
    }

    /**
     * End member deployment via resource update.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function endMemberDeployment(Request $request, $member_id, $bwh_id)
    {

        try {
            \DB::beginTransaction();

            $deployment = BranchWorkHistory::findOrFail($bwh_id);
            $deployment = $deployment->endDeployment($request->all(), $member_id, $bwh_id);

            return Response::json(["data" => $deployment]);
            if ($deployment) {
                \DB::commit();
                return Response::json($deployment, 200);
            }
        } catch (QueryException $e) {
            \DB::rollback();

            return Response::json(['status' => 1100], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();

            return Response::json(['status' => 1150], 404);
        }
    }
}
