<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataDukungDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'data_dukung_id',
        'tanggal',
        'kegiatan',
        'data_dkg',

    ];

    public function dataDukung()
    {
        return $this->belongsTo(DataDukung::class, 'data_dukung_id');
    }

    public function files() 
    {
        return $this->hasMany(DataDukungFile::class);
    }

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
}
