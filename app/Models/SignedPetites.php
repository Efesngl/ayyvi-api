<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignedPetites extends Model
{
    use HasFactory;
    protected $primaryKey="ID";
    public $incrementing =true;
    public $timestamps =false;
    protected $fillable=["petite_id","user_id","sign_reason","will_sign_showed","likes"];
}
