<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name','email_verified_at','auth_flag','remember_token','email','password'];

    use HasFactory;
}
