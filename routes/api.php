<?php

use App\Http\Controllers\api\V1\PetiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Users;
use App\Http\Controllers\api\V1\UserController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("/v1")->group(function () {
    Route::post("/login", [UserController::class,"login"]);
    Route::post("/register",[UserController::class,"register"]);
    Route::prefix("petites")->group(function(){
        Route::get("/getpopularpetites",[PetiteController::class,"get_popular_petites"]);
        Route::get("/getsuccededpetites",[PetiteController::class,"get_succeded_petites"]);
        Route::get("/browsepetites/{cat}",[PetiteController::class,"browse_petites"]);
        Route::get("/petitedetail/{id}",[PetiteController::class,"petite_detail"]);
        Route::post("/petitesignreasons",[PetiteController::class,"get_petite_sign_reasons"]);
        Route::post("/newpetite",[PetiteController::class,"create_petite"]);
        Route::post("/sign",[PetiteController::class,"sign_petite"]);
        Route::post("/unsign",[PetiteController::class,"unsign_petite"]);
        Route::post("/likesignreason",[PetiteController::class,"like_sign_reason"]);
        Route::post("/unlikesignreason",[PetiteController::class,"unlike_sign_reason"]);
    });
    Route::prefix("user")->group(function(){
        Route::post("/updateuserdetail",[UserController::class,"update_user_detail"]);
        Route::get("/getuserpetites",[PetiteController::class,"get_user_petites"]);
        Route::get("/getjoinedpetites",[PetiteController::class,"get_joined_petites"]);
    });
    Route::get("/gettopics",function(){
        return response()->json([
            "topics"=>DB::table("topics")->get()
        ]);
    });
});
