<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/download/{filename}", function ($filename) {
    return Response::download(storage_path("\\excel\\reports\\") . $filename . ".xlsx");
});


Route::get("/download-document/{filename}", function ($filename) {
    return Response::download(storage_path("app\public\documents") . "\\" . $filename . ".pdf");
});

Route::get("register/success", "AuthController@successForm")->name("register-success");
Route::get("register/{token_id}", "AuthController@registerForm");
Route::post("register/{token_id}", "AuthController@register");
Route::get("user/verify/{verification_code}", "AuthController@verify");
