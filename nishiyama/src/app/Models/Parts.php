<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'status', 'name', 'parts_image_file_path', 'screen_display_item', 'atrs_parts_code', 'disp_num', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
