<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id', 'comment', 'exhibitor_flg', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
