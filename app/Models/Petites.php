<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petites extends Model
{
    use HasFactory;
    protected $primaryKey="ID";
    public $incrementing =true;
    public $timestamps =false;
    protected $fillable=["petite_header","petite_content","petite_topic","petite_image","creator","target_sign"];
}
