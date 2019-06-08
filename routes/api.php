<?php

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\Gate;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(["prefix" => "auth"], function () {
    Route::post("register/{token}", "AuthController@register");
    Route::post("login", "AuthController@login");
    Route::get("logout/{user_id}", "AuthController@logout");
});

Route::group(["prefix" => "v1"], function () {
    Route::group(["middleware" => ["auth:api"]], function () {
        Route::get("user/me", "AuthController@me");

        Route::group(["middleware" => ["permission:system_users_full_access"]], function () {
            // User
            Route::post("users/{role_id}/invite", "UserController@sendInvite");
            Route::put("users/{user_id}/update", "UserController@updateSingleUser");
            Route::resource("users", "UserController");
            
            // User Groups
            Route::get('user-groups/all', 'UserGroupController@fetchAll');
            Route::resource('user-groups', 'UserGroupController');
            Route::get('user-groups/{role_id}/users', 'UserGroupController@getUsers');
            Route::get("user-groups/all", "UserGroupController@all");
        });

        // Member
        Route::resource("members", "MemberController", ["only" => ["index", "show"]]);
        
        Route::group(["middleware" => ["permission:add_member"]], function () {
            Route::resource("members", "MemberController", ["only" => ["store"]]);
        });

        Route::group(["middleware" => ["permission:modify_profile_of_members"]], function () {
            Route::resource("members", "MemberController", ["except" => ["index", "store", "show"]]);
        });
    
        Route::get("/reports/all", "ReportController@all");
        Route::get("/reports/{id}/template", "ReportController@generateTemplate");
        Route::resource("/reports", "ReportController");

        Route::group([
            "prefix" => "members",
            "middleware" => ["permission:modify_deployment"],
            "except" => ["index"]
        ], function () {
            Route::post("/{member_id}/deploy", "DeploymentController@storeMemberDeployment");
            Route::put("/{member_id}/update-deployment", "DeploymentController@updateMemberDeployment");
            Route::put("/{member_id}/end-deployment/{deploymnent}", "DeploymentController@endMemberDeployment");
        });
        
        // Other REST APIs
        Route::apiResource("members/{bwh_id}/disciplinary-actions", "DisciplinaryActionController");
        
        Route::group(["prefix" => "members"], function () {
            Route::get("/{id}/works", "MemberController@memberWorkHistory");
            Route::get("/{id}/documents", "MemberController@memberDocuments");
            Route::post("/{id}/upload", "MemberController@fileUpload");
            Route::post("/import", "MemberController@importCsv");
            Route::post("/bulk-upload-member", "MemberController@bulkUploadMember");
        });
        
        // Client
        Route::post("clients/upload", "ClientController@uploadClients");
        Route::post("business-units/upload", "BusinessUnitController@uploadBusinessUnits");
        Route::post("brands/upload", "BrandController@uploadBrands");
        Route::post("branches/upload", "BranchController@uploadBranches");

        Route::get("clients/all", "ClientController@all");
        Route::get("business-units/all", "BusinessUnitController@all");
        Route::get("clients/{id}/business-units/all", "BusinessUnitController@allPerClient");
        Route::get("clients/{id}/brands/all", "ClientBrandController@all");
        Route::get("clients/{id}/brands/{brand_id}/branches/all", "ClientBrandController@getBranches");
        Route::get("clients/{id}/brands/{brand_id}/members", "ClientBrandController@members");

        Route::group(["middleware" => ["permission:view_clients|view_add_and_modify_clients_branches_brands_bus"]], function () {
            Route::resource("clients", "ClientController", ["only" => ["index", "show"]]);
        });
        
        Route::group(["middleware" => ["permission:view_add_and_modify_clients_branches_brands_bus"]], function () {
            Route::resource("clients", "ClientController", ["except" => ["index", "show"]]);

            // Client - Business Units
            Route::apiResource("clients/{client_id}/business-units", "BusinessUnitController");
            
            // Client - Brands
            Route::apiResource("clients/{client_id}/brands", "ClientBrandController");

            // Client - Branches
            Route::apiResource("clients/{id}/branches", "BranchController");

            // Client - Members
            Route::put("clients/{id}/members/tenure", "ClientMemberController@endTenure");
            Route::put("clients/{id}/members/status", "ClientMemberController@updateStatus");
            Route::put("clients/{id}/members/branch", "ClientMemberController@reassignMembers");
            Route::apiResource("clients/{id}/members", "ClientMemberController");
        });
    
    
        // Settings
        Route::group(["prefix" => "settings"], function () {
            Route::get("positions/all", "PositionController@fetchAll");
            Route::post("positions/upload", "PositionController@uploadPositions");
            Route::get("brands/all", "BrandController@fetchAll");
            Route::get("employment-status/all", "EmploymentStatusController@fetchAll");
            Route::get("document-types/all", "DocumentTypeController@fetchAll");
            Route::get("regions/all", "RegionController@fetchAll");
            Route::get("cities/all", "CityController@fetchAll");
            Route::get("tenure-types/all", "TenureTypeController@fetchAll");
            Route::get("reasons-for-leaving/all", "ReasonController@fetchAll");
            Route::get("locations/all", "LocationController@fetchAll");
           
            Route::group(["middleware" => ["permission:system_settings"]], function () {
                Route::apiResource("employment-status", "EmploymentStatusController");
                Route::apiResource("document-types", "DocumentTypeController");
                Route::apiResource("regions", "RegionController");
                Route::apiResource("cities", "CityController");
                Route::apiResource("tenure-types", "TenureTypeController");
                Route::apiResource("reasons-for-leaving", "ReasonController");
                Route::apiResource("locations", "LocationController", ["except" => ["fetchAll"]]);
                Route::apiResource("positions", "PositionController");
                Route::apiResource("tenure-types", "TenureTypeController");
                Route::get("regions/{id}/cities", "RegionController@getCitiesUnderRegion");
            });
        });
    });
});
