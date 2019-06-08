<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use DB;
use Hash;
use Mail;
use Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    /**
     * Route located at web.php
     * links that verify the user when links get clicked
     * Redirects to register page
     *
     * @param string $token
     */
    public function verify($token)
    {
        \DB::beginTransaction();
        $check = DB::table("user_verifications")
                ->where("token", $token)
                ->first();

        if (!is_null($check)) {
            $user = User::findOrFail($check->user_id);

            if ($user->is_verified === 1) {
                return Response::json(["message" => "Account already verified.."]);
            }

            $user->is_verified = 1;
            if ($user->save()) {
                \DB::commit();
                return Redirect("/register" . "/" . $token);
            }

            return Response::json([
                "data" => "Error verifying. Please try again."
            ], 500);
        } else {
            return Response::json(["message" => "Invalid verification code"], 404);
        }
    }

    public function registerForm()
    {
        return Response::view("test.register");
    }

    public function successForm()
    {
        return Response::view("test.register-success");
    }

    /**
     * Stores the user's name and password in the storage
     *
     * @param Illuminate\Http\Request $request
     * @param string $param
     * @return Illuminate\Support\Facades\Response $response
     */
    public function register(Request $request, $token)
    {
        try {
            $credentials = $request->only("name", "password", "password_confirmation");
            $user_id = DB::table("user_verifications")->where("token", $token)->first()->user_id;
            $user = User::findOrFail($user_id);

            $rules = [
                "name" => "required|unique:users",
                "password" => "required|min:8|confirmed",
                "password_confirmation" => "required|min:8|same:password",
            ];
            
            $validator = Validator::make($credentials, $rules);
            if ($validator->fails()) {
                return Response::json(["status" => $validator->errors()->first()], 422);
            }

            $user->name = $credentials["name"];
            $user->password = Hash::make($credentials["password"]);
            $user->is_verified = 1;

            if ($user->save()) {
                return redirect()->to("/register/success")->send();
            }

            return Response::json(["stauts" => "1155"], 500);
        } catch (Exception $e) {
            return Response::json(["message" => $e->getMessage()]);
        }
    }

    /**
     * Logs out the user
     * @param int $user_id
     */
    public function logout($user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $tokens = $user->tokens;

            foreach ($tokens as $token) {
                $token->revoke();
            }
            Auth::logout();
            return Response::json([], 204);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        }
    }

    public function me()
    {
        $authorized_user = Auth::user();
        $user = User::where("id", $authorized_user->id)->first();

        $permissions = $user->getAllPermissions()->map(function ($item) {
            return ["id" => $item->id, "name" => $item->name];
        });

        $role = Role::find($user->roles->first()->id);

        return Response::json([
            "user" => $authorized_user,
            "client" => $role->clients,
            "permissions" => $permissions
        ]);
    }
}
