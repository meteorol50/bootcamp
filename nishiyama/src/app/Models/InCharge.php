<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InCharge extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const DELETED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'company_id', 'name', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'
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
