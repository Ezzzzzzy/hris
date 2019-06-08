<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\User;
use App\Classes\Paginate;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\UserGroupResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Client;
use App\Models\RoleHasClient;
use App\Models\Role as RoleModel;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query("page") ? $request->query("page") : 1;
            $limit = $request->query("limit") ? $request->query("limit") : 10;
            $result = RoleModel::getUserGroups();

            // search
            if ($request->query("q")) {
                $keyword = $request->query("q");
                $result = $this->search($result, $keyword);
            }

            $result = new Paginate($result, $page, $limit);
            return Response::json($result::paginate());
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
        }
    }

    /**
     * Display all listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        try {
            return Response::json(["data" => RoleModel::all()]);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
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
        try {
            \DB::beginTransaction();

            $role = Role::create([
                "name" => $request["user-group"]["name"],
                "description" => $request["user-group"]["description"],
                "status" => $request["user-group"]["status"],
                "status_color" => $request["user-group"]["status_color"],
                "guard_name" => "web"
            ]);

            if (count($request->permissions["members"]) == 0) {
                $members_permissions = new Permission;

                $members_permissions = $members_permissions->where("type", "members")->select("name")->get();
                foreach ($members_permissions as $memPermission) {
                    $role->givePermissionTo($memPermission->name);
                }
            } else {
                foreach ($request->permissions["members"] as $memPermission) {
                    $role->givePermissionTo($memPermission);
                }
            }
    
            $role->givePermissionTo($request->permissions["client_permission"]);
            $role->givePermissionTo($request->permissions["reports"]);
            $role->givePermissionTo($request->permissions["users"]);
            $role->givePermissionTo($request->permissions["settings"]);
    
            $role = RoleModel::findOrFail($role->id);
            if (count($request->permissions["client_access"]) == 0) {
                $clients = new Client;
                $clients = $clients->select("name");
            }
            $role->clients()->sync($request->permissions["client_access"]);
            \DB::commit();

            return Response::json(["data" => $role]);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json(["status" => 1100], 500);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["status" => 1100], 500);
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
            $result = RoleModel::findOrFail($id);
            $result->getAllPermissions();
            $result->clients;

            return Response::json(["data" => $result]);
        } catch (ModelNotFoundException $e) {
            return Response::json(["status" => 1155], 404);
        } catch (QueryException $e) {
            return Response::json(["status" => 1100], 500);
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
            $permissions = [];

            array_push($permissions, $request->permissions["client_permission"]);
            array_push($permissions, $request->permissions["reports"]);
            array_push($permissions, $request->permissions["users"]);
            array_push($permissions, $request->permissions["settings"]);

            $default = [];
            if (count($request->permissions["members"]) == 0) {
                $members = new Permission;
                $members = $members->where("type", "members")->select("name")->get();
                foreach ($members as $member) {
                    array_push($default, $member->name);
                }
                $permissions = array_merge($permissions, $default);
            } else {
                $permissions = array_merge($permissions, $request->permissions["members"]);
            }

            $role = Role::findOrFail($id);
            $role->fill($request["user-group"]);
            $role->save();
            $role->syncPermissions($permissions);
            $role = RoleModel::findOrFail($role->id);
            if (count($request->permissions["client_permission"]) === 0) {
                $role->clients()->sync([]);
            } else {
                $role->clients()->sync($request->permissions["client_access"]);
            }

            \DB::commit();
            return Response::json(["data" => $role::with(["permissions", "clients"])->find($id)]);
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return Response::json(["data" => 1155], 404);
        } catch (QueryException $e) {
            \DB::rollback();
            return Response::json(["data" => 1100], 500);
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
        $role = Role::findOrFail($id);
        $roleModel = RoleModel::findOrFail($id);
        // return $roleModel::with(["permissions","clients"])->get();
        $users = $role->users;
        foreach ($users as $user) {
            $userModel = new User;
            $userModel = $userModel->findOrFail($user->id);
            $userModel->removeRole($role);
            $userModel->delete();
        }
        $roleModel->clients()->sync([]);
        $role->syncPermissions([]);
        $roleModel->delete();
        

        return $role->users;
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
            return false !== (stristr($item["name"], $keyword) || stristr($item["id"], $keyword));
        })->values();
    }

    public function fetchAll()
    {
        $result = RoleModel::getUserGroups();

        if ($result) {
            return Response::json(["data" => $result]);
        }

        return Response::json(["status" => 1153], 404);
    }
}
