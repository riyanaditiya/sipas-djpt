<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pejabat extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_id',
        'nama',
        'jabatan',
        'tgl_pengangkatan',
        'dokumen_sk',
    ];

    // TAMBAHKAN INI
    protected $casts = [
        'nama' => 'array',
        'jabatan' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}