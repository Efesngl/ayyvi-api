<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\PetitionDetailResource;
use App\Models\Petitions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;

class PetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        //
        $search=$req->query("s");
        $is_search_set=isset($search);
        $limit=$req->query("offset");
        $page=$req->query("page")-1;
        $offset=$limit*$page;
        $p = Petitions::select("petitions.ID", "petitions.petition_header", "created_at", "statuses.status", "statuses.ID as statusID")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as 'creator'")
            ->join("users", "users.ID", "=", "petitions.creator")
            ->join("statuses", "statuses.ID", "=", "petitions.status")
            ->when($is_search_set,function(Builder $b) use ($search){
                $b->where("petition_header","like","%".$search."%");
            });
        return response()->json([
            "totalPetitions"=>$p->count(),
            "petitions"=>$p->limit($limit)->offset($offset)->get()
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
        $p=Petitions::where("petitions.ID",$id)
        ->leftJoin("signed_petitions","signed_petitions.petition_id","=","petitions.ID")
        ->select("petition_topic","petition_header","petition_image","target_sign","petition_content","status","creator")
        ->selectRaw("count(signed_petitions.petition_id) as total_signed")
        ->first();
        return response()->json(new PetitionDetailResource($p));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $p=$request->input("p");
        $arr=[
            "petition_header"=>$p["petitionHeader"],
            "petition_content"=>$p["petitionContent"],
            "target_sign"=>$p["targetSign"],
            "petition_topic"=>$p["petitionTopic"],
            "status"=>$p["status"],
            "petition_image"=>$p["petitionImage"]
        ];
        Petitions::where("ID",$id)->update($arr);
        return response("",200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
