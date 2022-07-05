<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorite';
    const DELETED = 0;

    protected $fillable = [
        'item_id', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
