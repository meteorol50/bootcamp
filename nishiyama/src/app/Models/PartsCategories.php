<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartsCategories extends Model
{
    use HasFactory;

     protected $fillable = [
        'status', 'name', 'core_return_flag', 'disp_num', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
