<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    //
    public function make_donate(Request $req){
        $donation=$req->input("donation");
        $user=$req->input("user");
        if(DB::table("donations")->insert([
            "user_id"=>$user,
            "donation_amount"=>$donation["amount"]
        ])){
            return response("",201);
        }
        return response("",404);
    }
    public function get_donations(Request $req){
        $donations=DB::table("donations")->select("donation_amount as donationAmount","donated_at as donatedAt")->where("user_id",$req->query("user"))->get();
        return response()->json([$donations]);
    }
}
