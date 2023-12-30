<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetiteEditResource;
use App\Http\Resources\V1\PetitionDetailResource;
use App\Http\Resources\V1\PetitionResource;
use App\Models\Petitions;
use App\Models\SignedPetitions;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PetitionController extends Controller
{
    //
    public function get_succeded_petitions(Request $req)
    {
        $offset=$req->query("offset");
        $petitions = petitions::join("users", "petitions.creator", "=", "users.ID")
            ->leftJoin("signed_petitions", "signed_petitions.petition_id", "=", "petitions.ID")
            ->select("petitions.ID", "petitions.petition_header", "created_at", "petition_image", "user_pp", "target_sign")
            ->selectRaw("concat(left(petition_content,67),'...') as 'petition_content'")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as creator")
            ->selectRaw("count(signed_petitions.petition_id) as 'total_signed'")
            ->whereNot(function (Builder $b) {
                $b->where("is_succeded", 0);
            })
            ->where("is_success_allowed",1)
            ->groupByRaw("petitions.ID")
            ->offset($offset)
            ->limit(5)
            ->get();


        return response()->json(petitionResource::collection($petitions));
    }
    public function get_popular_petitions(Request $req)
    {
        $offset=$req->query("offset") ?? 0;
        $popular_petitions = petitions::join("signed_petitions", "signed_petitions.petition_id", "=", "petitions.ID")
            ->join("users", "users.ID", "=", "petitions.creator")
            ->select("petitions.ID", "petitions.petition_header", "created_at", "petition_image", "user_pp", "target_sign")
            ->selectRaw("concat(left(petition_content,67),'...') as 'petition_content'")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as creator")
            ->selectRaw("count(signed_petitions.petition_id) as 'total_signed'")
            ->where("is_succeded", 0)
            ->groupByRaw("signed_petitions.petition_id")
            ->orderByRaw("count(*) desc,signed_petitions.signed_at desc")
            ->havingRaw("count(*)>10")
            ->offset($offset)
            ->limit(5)
            ->get();
        return response()->json(petitionResource::collection($popular_petitions));
    }
    public function get_newest_petitions(Request $req)
    {
        $offset=$req->query("offset");
        $petitions = petitions::join("users", "users.ID", "=", "petitions.creator")
            ->join("signed_petitions", "signed_petitions.petition_id", "=", "petitions.ID")
            ->select("petitions.ID", "petition_header", "created_at", "petition_image", "target_sign")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as 'creator'")
            ->selectRaw("concat(left(petition_content,97),'...') as 'petition_content'")
            ->selectRaw("count(signed_petitions.petition_id) as 'total_signed'")
            ->groupByRaw("signed_petitions.petition_id")
            ->havingRaw("count(signed_petitions.petition_id) > 10")
            ->where("petitions.is_succeded", 0)
            ->offset($offset)
            ->limit(5)
            ->get();
        return response()->json(petitionResource::collection($petitions));
    }
    public function browse_petitions(Request $req,$cat)
    {
        switch ($cat) {
            case 'newest':
                # code...
                return  $this->get_newest_petitions($req);
                break;
            case "popular":
                return $this->get_popular_petitions($req);
                break;
            case "succeded":
                return $this->get_succeded_petitions($req);
                break;
            default:
                # code...
                break;
        }
    }
    public function create_petition(Request $req)
    {
        $petition = $req->input("petition");
        $image = $petition["petitionImage"]["url"];
        $image = preg_replace('#data:image/[^;]+;base64,#', '', $image);
        $img_data = base64_decode($image);
        $src = imagecreatefromstring($img_data);
        $petition_created = [
            "petition_header" => $petition["petitionHeader"],
            "petition_content" => $petition["petitionContent"],
            "petition_topic" => $petition["petitionTopic"],
            "creator" => $req->input("user"),
            "target_sign" => $petition["targetSign"],
        ];
        $id=Petitions::insertGetId($petition_created);
        $image_path = public_path("/storage/petition_images/");
        $maxExecTime = time() + 5;
        $isFileNameUnique = false;
        $fileName = "";
        while (time() !== $maxExecTime) {
            $fileName = "{$id}_" . uniqid(mt_rand(), true) . ".webp";
            if (!file_exists($image_path . $fileName)) {
                $isFileNameUnique = true;
                break;
            }
        }
        if($isFileNameUnique){
            if (imagewebp($src, $image_path.$fileName)) {
                imagedestroy($src);
                Petitions::where("ID",$id)->update([
                    "petition_image"=>"/storage/petition_images/{$fileName}"
                ]);
                return response("",200);
            }
        }else{
            return response()->json([
                "error"=>"Resim zaten mevcut"
            ],404);
        }

    }
    public function petition_detail(Request $req, int $id)
    {
        $type = $req->query("type");
        if ($type == "detail") {
            $user_id = $req->query("user");
            $petition = petitions::join("users", "users.ID", "=", "petitions.creator")
                ->select("petitions.ID", "is_succeded", "petition_header", "petition_image", "petition_content", "created_at", "target_sign", "user_pp")
                ->selectRaw("concat(users.firstname,' ',users.lastname) as 'creator'")
                ->selectRaw("(select count(*) from signed_petitions where petition_id={$id}) as 'total_signed'")
                ->selectRaw("if((select count(*) from signed_petitions where user_id={$req->query('user')} and petition_id={$id})=1,1,0) as isSigned")
                ->selectRaw("if(petitions.creator={$user_id},true,false) as does_belong_to_user")
                ->where("petitions.ID", $id)
                ->get();
            return response()->json([
                "petition" => PetitionDetailResource::collection($petition),
            ],);
        } else {
            $petition = Petitions::where("ID", $id)
                ->select("petitions.*")
                ->selectRaw("(select count(*) from signed_petitions where petition_id={$id}) as 'total_signed'")
                ->get();
            return response()->json([
                "petition" => PetiteEditResource::collection($petition)
            ]);
        }
    }
    public function sign_petition(Request $req)
    {
        $input = $req->input("data");
        // return $req->host();
        $sign = Signedpetitions::create([
            "user_id" => $input["userID"],
            "petition_id" => $input["petitionID"],
        ]);
        if (!$sign->exists()) return response("sign", 404);
        $reason = null;
        if (isset($input["signReason"])) {
            $reason = DB::table("sign_reasons")->insert([
                "reason_id" => $sign["ID"],
                "reason" => $input["signReason"]["reason"],
                "will_reason_showed" => ($input["signReason"]["willShowed"] == true) ? 1 : 0
            ]);
            if (!$reason) return response("reason", 404);
        }
        return response("", 201);
    }
    public function unsign_petition(Request $req)
    {
        $input = $req->input("data");
        $reason_id = Signedpetitions::where([
            ["user_id", $input["userID"]],
            ["petition_id", $input["petitionID"]]
        ])->first()["ID"];
        $unsign = Signedpetitions::where([
            ["user_id", $input["userID"]],
            ["petition_id", $input["petitionID"]]
        ])->delete();
        if (!$unsign) return response("", 404);
        $sign_reason = DB::table("sign_reasons")->where("reason_id", $reason_id);
        if ($sign_reason->exists()) {
            if (!$sign_reason->delete()) return response("", 404);
        }
        return response("", 200);
    }
    public function get_petition_sign_reasons(Request $req)
    {
        $petition_id = $req->input("petitionID");
        $user_id = $req->input("userID");
        $reasons = Signedpetitions::join("users", "users.ID", "=", "signed_petitions.user_id")
            ->join("sign_reasons", "sign_reasons.reason_id", "=", "signed_petitions.ID")
            ->leftJoin("sign_reason_likes", "sign_reasons.ID", "=", "sign_reason_likes.reason_id")
            ->select("sign_reasons.ID as reason_id", "sign_reasons.reason as reason", "users.user_pp as userPP")
            ->selectRaw("count(sign_reason_likes.reason_id) as likes")
            ->selectRaw("concat(users.firstname,' ',users.lastname) as signer")
            ->when($user_id, function (Builder $query, int $user_id) {
                $query->selectRaw("if((select count(*) from sign_reason_likes where user_id={$user_id} and reason_id=sign_reasons.ID)=1,1,0) as isLiked");
            })
            ->where("signed_petitions.petition_id", $petition_id)
            ->groupBy("sign_reasons.reason_id")
            ->get();
        return $reasons;
    }
    public function like_sign_reason(Request $req)
    {
        $reason_id = $req->input("reasonID");
        $user_id = $req->input("userID");
        DB::table("sign_reason_likes")->insert([
            "reason_id" => $reason_id,
            "user_id" => $user_id
        ]);
    }
    public function unlike_sign_reason(Request $req)
    {
        $reason_id = $req->input("reasonID");
        $user_id = $req->input("userID");
        DB::table("sign_reason_likes")->where([
            ["user_id", $user_id],
            ["reason_id", $reason_id]
        ])->delete();
    }
    public function get_more_petition()
    {
    }

    public function get_user_petitions(Request $req)
    {
        $user_id = $req->query("userID");
        $petitions = petitions::where("creator", $user_id)
            ->leftJoin("signed_petitions", "signed_petitions.petition_id", "=", "petitions.ID")
            ->select("petitions.ID", "petition_header", "created_at", "is_succeded", "petition_image", "petition_topic", "target_sign")
            ->selectRaw("concat(left(petition_content,67),'...') as petition_content")
            ->selectRaw("count(signed_petitions.petition_id) as 'total_signed'")
            ->groupByRaw("petitions.ID")
            ->get();
        return response()->json([
            "petitions" => $petitions
        ]);
    }
    public function get_joined_petitions(Request $req)
    {
        $user_id = $req->query("userID");
        $petitions = petitions::join("signed_petitions", "signed_petitions.petition_id", "=", "petitions.ID")
            ->select("petitions.ID", "petition_header", "created_at", "is_succeded", "petition_image", "petition_topic", "target_sign")
            ->selectRaw("concat(left(petition_content,67),'...') as petition_content")
            ->selectRaw("count(petitions.ID) as 'total_signed'")
            ->groupByRaw("signed_petitions.petition_id")
            ->where("signed_petitions.user_id", $user_id)
            ->get();
        return response()->json([
            "petitions" => $petitions
        ]);
    }

    public function update_petition(Request $req)
    {
        $p = $req->input("petition");
        $petition = [
            "petition_header" => $p["petitionHeader"],
            "petition_content" => $p["petitionContent"],
            "petition_topic" => $p["petitionTopic"],
            "target_sign" => $p["targetSign"],
            "is_succeded" => $p["isSucceded"],
        ];
        if (isset($p["petitionImage"]["url"])) {
            $image = $p["petitionImage"]["url"];
            $image = preg_replace('#data:image/[^;]+;base64,#', '', $image);
            $img_data = base64_decode($image);
            $src = imagecreatefromstring($img_data);
            $image_path = base_path("frontend/public/assets/img/");
            $maxExecTime = time() + 5;
            $isFileNameUnique = false;
            $fileName = "";
            while (time() !== $maxExecTime) {
                $fileName = "{$p['ID']}_" . uniqid(mt_rand(), true) . ".{$p["petitionImage"]["extension"]}";
                if (!file_exists($image_path . $fileName)) {
                    $isFileNameUnique = true;
                    break;
                }
            }
            if ($isFileNameUnique) {
                if (imagejpeg($src, $image_path . $fileName)) {
                    imagedestroy($src);
                    $petition["petition_image"] = "/assets/img/{$fileName}";
                }
            } else {
                return response()->json(["error" => "Resim zaten mevcut"], 400);
            }
        }
        Petitions::where("ID", $p["ID"])->update($petition);
        return response("",200);
    }
    public function delete_petition(Request $req){
        $petition_id=$req->input("ID");
        $p=Petitions::where("ID",$petition_id)->first();
        $image_path=base_path("frontend/public/{$p["petition_image"]}");
        if(Petitions::destroy($petition_id)>0){
            unlink($image_path);
            return response("",200);
        }
        return response("",404);
    }
}
