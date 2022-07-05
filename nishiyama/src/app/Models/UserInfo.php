<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_info';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image', 'postal_code', 'prefecture_id', 'city', 'address', 'building', 'tel', 'fax', 'other', 'shipping_id', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Validation rules for current model
     *
     * @return Collection
     */
    public static function rules()
    {
        return collect([

        ]);
    }
}
