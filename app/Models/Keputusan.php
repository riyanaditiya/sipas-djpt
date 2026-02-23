<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keputusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_id',
        'nomor_surat',
        'tentang',
        'tanggal_penetapan',
        'keterangan',
        'file_path',
        'file_name',
        'passcode',
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
