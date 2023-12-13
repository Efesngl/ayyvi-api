<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PetiteDetailResource;
use App\Http\Resources\V1\PetiteResource;
use App\Models\Petites;
use App\Models\SignedPetites;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Facades\DB;

class PetiteController extends Controller
{
    //
    public function get_succeded_petites()
    {
        $petites = Petites::join("users", "petites.creator", "=", "users.ID")
            ->join("signed_petites", "signed_petites.petite_id", "=", "petites.ID")
            ->select("petites.ID", "petites.petite_header", "created_at", "petite_image", "user_pp", "target_sign")
            ->selectRaw("concat(left(petite_content,67),'...') as 'petite_content'")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as creator")
            ->selectRaw("count(signed_petites.petite_id) as 'total_signed'")
            ->whereNot(function (Builder $b) {
                $b->where("is_succeded", 0);
            })
            ->when()
            ->groupByRaw("signed_petites.petite_id")
            ->get();


        return response()->json(PetiteResource::collection($petites), 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function get_popular_petites()
    {
        $popular_petites = Petites::join("signed_petites", "signed_petites.petite_id", "=", "petites.ID")
            ->join("users", "users.ID", "=", "petites.creator")
            ->select("petites.ID", "petites.petite_header", "created_at", "petite_image", "user_pp", "target_sign")
            ->selectRaw("concat(left(petite_content,67),'...') as 'petite_content'")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as creator")
            ->selectRaw("count(signed_petites.petite_id) as 'total_signed'")
            ->where("is_succeded", 0)
            ->groupByRaw("signed_petites.petite_id")
            ->orderByRaw("count(*) desc,signed_petites.signed_at desc")
            ->havingRaw("count(*)>5")
            ->get();
        return response()->json(PetiteResource::collection($popular_petites), 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function browse_petites($cat)
    {
        switch ($cat) {
            case 'newest':
                # code...
                $petites = Petites::join("users", "users.ID", "=", "petites.creator")
                    ->join("signed_petites", "signed_petites.petite_id", "=", "petites.ID")
                    ->select("petites.ID", "petite_header", "created_at", "petite_image", "target_sign")
                    ->selectRaw("concat(users.firstname,' ',users.lastname) as 'creator'")
                    ->selectRaw("concat(left(petite_content,97),'...') as 'petite_content'")
                    ->selectRaw("count(signed_petites.petite_id) as 'total_signed'")
                    ->groupByRaw("signed_petites.petite_id")
                    ->havingRaw("count(signed_petites.petite_id) > 10")
                    ->where("petites.is_succeded", 0)
                    ->get();
                return response()->json([
                    "petites" => PetiteResource::collection($petites)
                ]);
                break;
            case "popular":
                return $this->get_popular_petites();
                break;
            case "succeded":
                return $this->get_succeded_petites();
                break;
            default:
                # code...
                break;
        }
    }
    public function create_petite(Request $req)
    {
        $petite = $req->input("petite");
        $image = $petite["petiteImage"]["url"];
        $image = preg_replace('#data:image/[^;]+;base64,#', '', $image);
        $img_data = base64_decode($image);
        $src = imagecreatefromstring($img_data);
        $image_path = base_path("frontend/public/assets/img/{$petite['petiteImage']['name']}.{$petite['petiteImage']['extension']}");
        if (imagejpeg($src, $image_path)) {
            imagedestroy($src);
            $petite_created = Petites::create([
                "petite_header" => $petite["petiteHeader"],
                "petite_content" => $petite["petiteContent"],
                "petite_topic"=>$petite["petiteTopic"],
                "petite_image" =>   "/assets/img/{$petite['petiteImage']['name']}.{$petite['petiteImage']['extension']}",
                "creator" => $req->input("user"),
                "target_sign" => $petite["targetSign"],
                "total_signed" => 0,
            ]);
            return response()->json([
                "petite" => $petite_created
            ]);
        }
    }
    public function petite_detail(Request $req,int $id)
    {
        $user_id=$req->query("user");
        $petite = Petites::join("users","users.ID","=","petites.creator")
        ->select("petites.ID","is_succeded","petite_header","petite_image","petite_content","created_at","target_sign","user_pp")
        ->selectRaw("concat(users.firstname,' ',users.lastname) as 'creator'")
        ->selectRaw("(select count(*) from signed_petites where petite_id={$id}) as 'total_signed'")
        ->selectRaw("if((select count(*) from signed_petites where user_id={$req->query('user')} and petite_id={$id})=1,1,0) as isSigned")
        ->selectRaw("if(petites.creator={$user_id},true,false) as does_belong_to_user")
        ->where("petites.ID",$id)
        ->get();
        return response()->json([
            "petite"=>PetiteDetailResource::collection($petite),
        ], 200, [],JSON_UNESCAPED_UNICODE);
    }
    public function sign_petite(Request $req){
        $input=$req->input("data");
        // return $req->host();
        $sign=SignedPetites::create([
            "user_id"=>$input["userID"],
            "petite_id"=>$input["petiteID"],
        ]);
        if(!$sign->exists()) return response("sign",404);
        $reason=null;
        if(isset($input["signReason"])){
            $reason=DB::table("sign_reasons")->insert([
                "reason_id"=>$sign["ID"],
                "reason"=>$input["signReason"]["reason"],
                "will_reason_showed"=>($input["signReason"]["willShowed"]==true)?1:0
            ]);
            if(!$reason) return response("reason",404);
        }
        return response("",201);
    }
    public function unsign_petite(Request $req){
        $input=$req->input("data");
        $reason_id=SignedPetites::where([
            ["user_id",$input["userID"]],
            ["petite_id",$input["petiteID"]]
        ])->first()["ID"];
        $unsign=SignedPetites::where([
            ["user_id",$input["userID"]],
            ["petite_id",$input["petiteID"]]
        ])->delete();
        if(!$unsign) return response("",404);
        $sign_reason=DB::table("sign_reasons")->where("reason_id",$reason_id);
        if($sign_reason->exists()){
            if(!$sign_reason->delete()) return response("",404);
        }
        return response("",200);   
    }
    public function get_petite_sign_reasons(Request $req){
        $petite_id=$req->input("petiteID");
        $user_id=$req->input("userID");
        $reasons=SignedPetites::join("users","users.ID","=","signed_petites.user_id")
        ->join("sign_reasons","sign_reasons.reason_id","=","signed_petites.ID")
        ->leftJoin("sign_reason_likes","sign_reasons.ID","=","sign_reason_likes.reason_id")
        ->select("sign_reasons.ID as reason_id","sign_reasons.reason as reason","users.user_pp as userPP")
        ->selectRaw("count(sign_reason_likes.reason_id) as likes")
        ->selectRaw("concat(users.firstname,' ',users.lastname) as signer")
        ->when($user_id,function(Builder $query,int $user_id){
            $query->selectRaw("if((select count(*) from sign_reason_likes where user_id={$user_id} and reason_id=sign_reasons.ID)=1,1,0) as isLiked");
        })
        ->where("signed_petites.petite_id",$petite_id)
        ->groupBy("sign_reasons.reason_id")
        ->get();
        return $reasons;
    }
    public function like_sign_reason(Request $req){
        $reason_id=$req->input("reasonID");
        $user_id=$req->input("userID");
        DB::table("sign_reason_likes")->insert([
            "reason_id"=>$reason_id,
            "user_id"=>$user_id
        ]);
    }
    public function unlike_sign_reason(Request $req){
        $reason_id=$req->input("reasonID");
        $user_id=$req->input("userID");
        DB::table("sign_reason_likes")->where([
            ["user_id",$user_id],
            ["reason_id",$reason_id]
        ])->delete();
    }
    public function get_more_petite(){
    }

    public function get_user_petites(Request $req){
        $user_id=$req->query("userID");
        $petites=Petites::where("creator",$user_id)
        ->leftJoin("signed_petites","signed_petites.petite_id","=","petites.ID")
        ->select("petites.ID","petite_header","created_at","is_succeded","petite_image","petite_topic","target_sign")
        ->selectRaw("concat(left(petite_content,67),'...') as petite_content")
        ->selectRaw("count(signed_petites.petite_id) as 'total_signed'")
        ->groupByRaw("petites.ID")
        ->get();
        return response()->json([
            "petites"=>$petites
        ]);
    }
    public function get_joined_petites(Request $req){
        $user_id=$req->query("userID");
        $petites=Petites::join("signed_petites","signed_petites.petite_id","=","petites.ID")
        ->select("petites.ID","petite_header","created_at","is_succeded","petite_image","petite_topic","target_sign")
        ->selectRaw("concat(left(petite_content,67),'...') as petite_content")
        ->selectRaw("count(petites.ID) as 'total_signed'")
        ->groupByRaw("signed_petites.petite_id")
        ->where("signed_petites.user_id",$user_id)
        ->get();
        return response()->json([
            "petites"=>$petites
        ]);
    }
}
