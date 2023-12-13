<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $primaryKey="ID";
    public $incrementing =true;
    public $timestamps =false;
    protected $fillable=["firstname","lastname","email","password","pass_unhashed"];
}
