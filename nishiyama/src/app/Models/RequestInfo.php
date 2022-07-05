<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestInfo extends Model
{
    use HasFactory;

    protected $table = "request_info";

    const ACTIVE = 1;

    protected $fillable = [
        'confirm_request_contents', 'parts_id', 'vehicle_no', 'car_model_designation_no', 'classification_classification_no', 'car_models_name', 'model_year_month', 'request_for_parts', 'request_memo','user_id','status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
