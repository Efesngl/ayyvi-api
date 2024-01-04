<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DonationResource;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        //
        $total_donations=DB::table("donations")->count();
        $limit=$req->query("offset");
        $page=$req->query("page")-1;
        $offset=$limit*$page;
        $dontaions=DB::table("donations")
        ->join("users","users.ID","=","donations.user_id")
        ->select("donation_amount","donated_at","users.ID as donator_id")
        ->selectRaw("concat(users.firstname,' ',users.lastname) as donator")
        ->limit($limit)
        ->offset($offset)
        ->get();
        return response()->json([
            "donations"=>DonationResource::collection($dontaions),
            "totalDonations"=>$total_donations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
