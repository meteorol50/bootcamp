<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id', 'from', 'to', 'cc', 'bcc', 'body', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
