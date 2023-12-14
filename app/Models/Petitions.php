<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petitions extends Model
{
    use HasFactory;
    protected $primaryKey="ID";
    public $incrementing =true;
    public $timestamps =false;
    protected $fillable=["petition_header","petition_content","petition_topic","petition_image","creator","target_sign"];
}
