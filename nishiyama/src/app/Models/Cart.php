<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cart';
    protected $fillable = [
       'user_id','status','item_id','vehicle_no','created_at','updated_at', 'created_by', 'updated_by'
    ];
}
