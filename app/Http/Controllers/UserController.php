<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use App\User;
use App\Classes\Paginate;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Displays a list of user with its corresponding role/user-group
     *
     * @return \Illuminate\Support\Collection $result
     */
    public function index(Request $request)
    {
        $limit = $request->query("limit") ? $request->query("limit") : 10;
        $page = $request->query("page") ? $request->query("page") : 1;
        $result = User::getUsers();

        // search
        if ($request->query("q")) {
            $keyword = $request->query("q");
            $result = $this->search($result, $keyword);
        }

        // filter
        if ($request->query("group_id")) {
            $result = $this->filter($result, $request->query("group_id"));
        }

        $result = new Paginate($result, $page, $limit);
        return Response::json($result::paginate());
    }

    public function show($id)
    {
        try {
            $result = User::findOrFail($id);
            $result->roles->first();
            
            return Response::json(["data" => $result]);
        } catch(ModelNotFoundException $e) {
            return Response::json([
                    "status" => 404,
                    "error" => $e->getMessage()
            ], 404);
        } catch(QueryException $e) {
            return Response::json([
                "status" => 500,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function updateSingleUser(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            
            $validator = Validator::make($request->all(), [
                "name" => [
                    "required",
                    Rule::unique("users")->ignore($user->id),
                ],
                "email" => [
                    "required",
                    Rule::unique("users")->ignore($user->id),
                ],
                "mobile_number" => "required",
            ]);

            if ($validator->fails()){
                return Response::json([
                    "error" => $validator->errors()->first(),
                    "status" => 1000
                ]);
            }

            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return Response::json([
                    "data" => $user
                ]);
            }

            return Response::json([
                "status" => 1100,
            ], 500);
        } catch(QueryException $e) {
            return Response::json([
                "status" => 1100,
                "error" => $e->getMessage()
            ], 500);
        } catch(ModelNotFoundException $e) {
            return Response::json([
                "status" => 1150,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Updates the specified resource
     *
     * @param \Illuminate\Http\Request $request
     * @param int $user_id
     * @return
     */
    public function update(Request $request, $user_id)
    {
        \DB::beginTransaction();
        try {
            $user = User::findOrFail($user_id);
            $admin_credentials = $request->only("admin_email", "admin_password");
            $user_credentials = $request->only("user_name", "user_password", "user_email", "user_mobile_number", "user_position", "user_role_id");
            $admin = User::where("email", $admin_credentials["admin_email"])->first();

            $admin_validator = Validator::make($admin_credentials, [
                "admin_email" => "required",
                "admin_password" => "required"
            ]);

            if ($admin_validator->fails()) {
                return Response::json([
                    "error" => $admin_validator->errors()->first(),
                    "status" => 1000
                ], 422);
            }

            if (!password_verify($admin_credentials["admin_password"], $admin->password)){
                return Response::json([
                    "error" => "Email and password of admin did not match",
                    "status" => 1100
                ]);
            }

            $user_validator = Validator::make($user_credentials, [
                "user_name" => "required",
                "user_email" => "required",
                "user_mobile_number" => "required",
                "user_position" => "required",
                "user_role_id" => "required",
            ]);

            if ($user_validator->fails()) {
                return Response::json([
                    "error" => $user_validator->errors()->first(),
                    "status" => 1100
                ]);
            }

            $modified_keys = [];
            foreach($user_credentials as $key => $value){
                if ($key !== "user_role_id") {
                    $modified_key = str_replace("user_", "", $key);
                    array_push($modified_keys, $modified_key);
                }
            }

            $role_id = array_pop($user_credentials);
            $request_user = array_combine($modified_keys, $user_credentials);

            $user->fill($request_user);
            $user->password = Hash::make($request_user["password"]);

            // re-assign group/role
            if ($user->roles->first()->id !== $role_id) {
                $newRole = Role::find($role_id);
                $user->roles()->sync([$newRole->id]);
            }

            if ($user->save()) {
                \DB::commit();
                return Response::json(["data" => $user->roles]);
            }

        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json([
                "error" => "User not found",
                "status" => 1100
            ], 404);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json([
                "error" => $e->getMessage(),
                "status" => 1155
            ], 500);
        }
    }

    /**
     * filters a collection and returns the filtered collection
     *
     * @param \Illuminate\Support\Collection $result
     * @param string $keyword
     * @return \Illuminate\Support\Collection $result
     */
    public function search($result, $keyword)
    {
        return $result->filter(function ($item, $key) use ($keyword) {
            // dd($item);
            return stristr($item["id"], $keyword) || stristr($item["email"], $keyword) || stristr($item["name"], $keyword);
        })->values();
    }

    /**
     * Filters the collection based on input
     *
     *
     */
    public function filter($result, $group_id)
    {
        return $result->filter(function ($item) use ($group_id) {
            if ($item["group_id"] == $group_id) {
                return $item;
            }
        })->values();
    }

    public function sendInvite(Request $request, $role_id)
    {
        \DB::beginTransaction();
        $error = [];
        try {
            $role = Role::findOrFail($role_id);
            
            $validator = Validator::make($request->all(), [
                "inviter" => "required|max:255",
                "emails" => "required"
            ]);

            if ($validator->fails()) {
                return Response::json(["status" => 1000], 422);
            }

            $emails = collect($request["emails"]);
            $check = User::whereIn("email", $request["emails"])->get();

            $alreadyRegistered = collect([]);
            $receivers = collect([]);

            if ($check->count() >= 1) {
                $alreadyRegistered = $check->map(function ($item) {
                    return $item->email;
                });
                
                $receivers = $emails->merge($alreadyRegistered)->diff($alreadyRegistered)->values();
            } else {
                $receivers = $emails;
            }

            $receivers->each(function ($email) use ($role, $request) {
                $user = new User;
                $user->email = $email;
    
                if ($user->save()) {
                    $user->assignRole($role->name);
                    $verification_code = str_random(30); //Generate verification code
                    
                    \DB::table("user_verifications")->insert(["user_id"=>$user->id, "token"=>$verification_code]);
                    
                    $subject =  $request["inviter"] . " has invited you to join " . $role->name . " team.";
                    $data = [
                        "verification_code" => $verification_code,
                        "role_name" => $role->name
                    ];
                    
                    if (!User::sendInvite($subject, $data, $email)) {
                        \DB::rollback();
                        $error[] = $email;
                        // throw new
                        throw new Swift_TransportException("An error occured.");
                    }
                }
            });
            
            if ($alreadyRegistered->count() > 0) {
                $message = $alreadyRegistered->implode(", ") . " was already used. The rest was given an email.";
            } else {
                $message = "Emails Invited";
            }
            
            \DB::commit();
            return Response::json(["data" => $message]);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["data" => 1150], 500);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json(["data" => 1100], 404);
        } catch (\Swift_TransportException $e) {
            \DB::rollback();
            return Response::json(["data" => 1150, "message" => $e->getMessage(), "mail" => $error], 500);
        }
    }
}
