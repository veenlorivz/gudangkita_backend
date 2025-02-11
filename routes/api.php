<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\TeamController;
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

Route::group(["prefix" => "auth", "middleware" => ["cors"]], function(){
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::post("logout/{id}", [AuthController::class, "logout"]);
});



Route::group(["middleware" => ["auth:sanctum", "cors"]], function() {
    Route::resource("products",ProductController::class);
    Route::resource("categories",CategoryController::class);
    Route::group(["prefix" => "incomes"], function() {
        Route::resource("/",IncomeController::class);
        Route::get("/stats",[IncomeController::class, "stats"]);
        Route::get("/total",[IncomeController::class, "total"]);
        Route::get("/{id}",[IncomeController::class, "show"]);
        Route::put("/{id}",[IncomeController::class, "update"]);
        Route::delete("/{id}",[IncomeController::class, "destroy"]);
    });
    Route::group(["prefix" => "outcomes"], function(){
        Route::resource("/",OutcomeController::class);
        Route::get("/stats",[OutcomeController::class, "stats"]);
        Route::get("/total",[OutcomeController::class, "total"]);
        Route::get("/{id}",[OutcomeController::class, "show"]);
        Route::put("/{id}",[OutcomeController::class, "update"]);
        Route::delete("/{id}",[OutcomeController::class, "destroy"]);
    });
    Route::resource("teams",TeamController::class);  
});