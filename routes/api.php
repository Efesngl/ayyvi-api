<?php

use App\Http\Controllers\api\v1\admin\DashboardController;
use App\Http\Controllers\api\v1\admin\DonationController as AdminDonationController;
use App\Http\Controllers\api\v1\admin\PetitionController as AdminPetitionController;
use App\Http\Controllers\api\v1\admin\SocialController;
use App\Http\Controllers\api\v1\admin\TopicController;
use App\Http\Controllers\api\v1\admin\UserController as AdminUserController;
use App\Http\Controllers\api\V1\DonationController;
use App\Http\Controllers\api\V1\PetitionController;
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
    Route::post("login", [UserController::class,"login"]);
    Route::post("register",[UserController::class,"register"]);
    Route::prefix("petitions")->group(function(){
        Route::get("getpopularpetitions",[PetitionController::class,"get_popular_petitions"]);
        Route::get("getsuccededpetitions",[PetitionController::class,"get_succeded_petitions"]);
        Route::get("browsepetitions",[PetitionController::class,"browse_petitions"]);
        Route::get("petitiondetail/{id}",[PetitionController::class,"petition_detail"]);
        Route::post("petitionsignreasons",[PetitionController::class,"get_petition_sign_reasons"]);
        Route::post("newpetition",[PetitionController::class,"create_petition"]);
        Route::post("sign",[PetitionController::class,"sign_petition"]);
        Route::post("unsign",[PetitionController::class,"unsign_petition"]);
        Route::post("likesignreason",[PetitionController::class,"like_sign_reason"]);
        Route::post("unlikesignreason",[PetitionController::class,"unlike_sign_reason"]);
        Route::post("updatepetition",[PetitionController::class,"update_petition"]);
        Route::post("deletepetition",[PetitionController::class,"delete_petition"]);
    });
    Route::prefix("user")->group(function(){
        Route::post("/updateuserdetail",[UserController::class,"update_user_detail"]);
        Route::get("/getuserpetitions",[PetitionController::class,"get_user_petitions"]);
        Route::get("/getjoinedpetitions",[PetitionController::class,"get_joined_petitions"]);
        Route::post("/forgotpassword",[UserController::class,"forgot_password"]);
        Route::post("/resetpassword",[UserController::class,"reset_password"]);
    });
    Route::get("gettopics",function(){
        return response()->json([
            "topics"=>DB::table("topics")->get()
        ]);
    });
    Route::prefix("admin")->group(function(){
        Route::resource("petitions",AdminPetitionController::class);
        Route::resource("users",AdminUserController::class);
        Route::resource("donations",AdminDonationController::class);
        Route::resource("topics",TopicController::class);
        Route::resource("socials",SocialController::class);
        Route::prefix("dashboard")->group(function(){
            Route::get("getdashboard",[DashboardController::class,"index"]);
        });
    });
    Route::post("donate",[DonationController::class,"make_donate"]);
    Route::get("donate",[DonationController::class,"get_donations"]);
    Route::get("getsocials",function(){
        $socials=DB::table("social_media")->get();
        return response()->json($socials);
    });
});
