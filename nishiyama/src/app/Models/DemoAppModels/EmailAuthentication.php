<?php

namespace App\Models\DemoAppModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAuthentication extends Model
{
    // use HasFactory;

    protected $table = 'email_authentication';

    protected $fillable = [
        'email',
        'authentication_code'
    ];
}
