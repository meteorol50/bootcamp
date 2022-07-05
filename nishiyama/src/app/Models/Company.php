<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    const TYPE_INDIVIDUAL = 3;
    const TYPE_SOLE_PROPRIETOR = 2;
    const TYPE_CORPORATION = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'name', 'image', 'postal_code', 'prefecture_id', 'city', 'address', 'building', 'tel', 'fax', 'other', 'shipping_id', 'created_at', 'updated_at', 'created_by', 'updated_by'
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

    public function companyShippings()
    {
        return $this->hasMany(CompanyShipping::class);
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
