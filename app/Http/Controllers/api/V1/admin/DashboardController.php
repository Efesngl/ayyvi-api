<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Models\Petitions;
use DivisionByZeroError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function diffToLastMonth($current,$last){
        if($current==0){
            return ($last!=0)?-100:0;
        }else{
            return round((1 - $last / $current) * 100);
        }
    }
    public function index(){
        $petitionsThatStartedLastMonth=DB::table("petitions")
        ->whereRaw("month(created_at) = month(CURRENT_DATE - INTERVAL 1 month)")
        ->whereRaw("year(created_at) = year(CURRENT_DATE - INTERVAL 1 month)")
        ->count();
        $petitionsThatCreatedThisMonth=DB::table("petitions")
        ->whereRaw("month(created_at) = month(CURRENT_DATE)")
        ->whereRaw("year(created_at) = year(CURRENT_DATE)")
        ->count();
        $lastMonthSigns=DB::table("signed_petitions")
        ->whereRaw("month(signed_at) = month(CURRENT_DATE - INTERVAL 1 month)")
        ->whereRaw("year(signed_at) = year(CURRENT_DATE - INTERVAL 1 month)")
        ->count(); 
        $thisMonthSigns=DB::table("signed_petitions")
        ->whereRaw("month(signed_at) = month(CURRENT_DATE)")
        ->whereRaw("year(signed_at) = year(CURRENT_DATE)")
        ->count();
        $lastMonthDonations=DB::table("donations")
        ->whereRaw("month(donated_at) = month(CURRENT_DATE - INTERVAL 1 month)")
        ->whereRaw("year(donated_at) = year(CURRENT_DATE - INTERVAL 1 month)")
        ->sum("donation_amount"); 
        $thisMonthDonations=DB::table("donations")
        ->whereRaw("month(donated_at) = month(CURRENT_DATE)")
        ->whereRaw("year(donated_at) = year(CURRENT_DATE)")
        ->sum("donation_amount");
        $arr=[
            "petitions"=>[
                "diffToLastMonthPetitions"=>$this->diffToLastMonth($petitionsThatCreatedThisMonth,$petitionsThatStartedLastMonth),
                "thisMonthPetitions"=>$petitionsThatCreatedThisMonth,
            ],
            "signs"=>[
                "DifftoLastMonthSign"=>$this->diffToLastMonth($thisMonthSigns,$lastMonthSigns),
                "thisMonthSign"=>$thisMonthSigns,
            ],
            "donations"=>[
                "diffToLastMonthDonations"=>$this->diffToLastMonth($thisMonthDonations,$lastMonthDonations),
                "thisMonthDonation"=>$thisMonthDonations
            ]
        ];
        return response()->json($arr);
    }
}
