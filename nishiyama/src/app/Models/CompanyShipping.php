<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyShipping extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'postal_code', 'prefecture_id', 'city', 'address', 'building', 'tel', 'created_at', 'updated_at', 'created_by', 'updated_by'
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

    public function company()
    {
        return $this->belongsTo(Company::class);
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
