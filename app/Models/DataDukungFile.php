<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataDukungFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_dukung_detail_id',
        'file_name',
        'file_path',
    ];
}
