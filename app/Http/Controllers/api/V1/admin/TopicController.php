<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\TopicResource;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
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
        $topics=DB::table("topics")
        ->when($is_search_set,function(QueryBuilder $q) use ($search){
            $q->where("topic","like","%".$search."%");
        });
        return response()->json([
            "totalTopics"=>$topics->count(),
            "topics"=>TopicResource::collection($topics->limit($limit)->offset($offset)->get())
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
        $topic=$request->input("t");
        if(DB::table("topics")->insert(["topic"=>$topic])) return response("",201);
        return response("",400); 
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
        if(DB::table("topics")->delete($id)>0) return response("",200);
        return response("",400);
    }
}
