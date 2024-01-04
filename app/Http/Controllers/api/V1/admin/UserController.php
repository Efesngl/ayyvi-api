<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\UserDetailResource;
use App\Http\Resources\admin\UserResource;
use App\Models\Petitions;
use App\Models\Users;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $u=Users::when($is_search_set,function(QueryBuilder $query) use ($search){
            $query->where("firstname","like","%".$search."%")->orWhere("lastname","like","%".$search."%");
        });
        return response()->json([
            "totalUsers"=>$u->count(),
            "users"=>UserResource::collection($u->limit($limit)->offset($offset)->get()),
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
        $u=Users::where("ID",$id)->select("firstname","lastname","email","user_pp")->first();
        $up=Petitions::where("creator",$id)->select("ID","petition_header as petitionHeader")->get();
        return response()->json([
            "user"=>new UserDetailResource($u),
            "petitions"=>$up
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $u=$request->input("u");
        $arr=[
            "firstname"=>$u["firstname"],
            "lastname"=>$u["lastname"],
            "email"=>$u["email"],
            "user_pp"=>$u["userPP"],
        ];
        if(isset($u["password"])) $arr["password"]=Hash::make($u["password"]);
        Users::where("ID",$id)->update($arr);
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
