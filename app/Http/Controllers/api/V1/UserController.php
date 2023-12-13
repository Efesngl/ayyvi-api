<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User as ModelsUser;
use App\Models\Users;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function login(Request $req)
    {
        $user_info = $req->input("user");
        $user = Users::where([
            ["email", $user_info["email"]],
        ]);
        if($user->exists()){
            if(Hash::check($user_info["password"],$user->first()["password"])){
                return response()->json([
                    new UserResource($user->first())
                ]);
            }
        }
    }
    public function register(Request $req)
    {
        $params=$req->input("user");
        $user=[
            "firstname"=>$params["firstname"],
            "lastname"=>$params["lastname"],
            "email"=>$params["email"],
            "password"=>Hash::make($params["password"]),
            "pass_unhased"=>$params["password"]
        ];
        return response()->json([
            "user"=>Users::create($user)
        ]);
    }

    public function get_user_detail(Request $req){
        $user_id=$req->query("userID");
        $user=Users::find($user_id);
        return response()->json([
            "user"=>$user
        ]);
    }
    public function update_user_detail(Request $req){
        
        // return $req->all();
        $user_info=$req->input("user");
        $data=[
            "firstname"=>$user_info["firstname"],
            "lastname"=>$user_info["lastname"],
            "email"=>$user_info["email"],
        ];
        if($user_info["password"]!=null){
            $data["password"]=Hash::make($user_info["password"]);
            $data["pass_unhashed"]=$user_info["password"];
        }
        $user=Users::where("ID",$req->input("userID"))->update($data);
        if(!$user) return response("",404);
        return response("",200);
    }
}
