<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataDukung extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_id',
        'produk_hukum',
        'keterangan',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
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
