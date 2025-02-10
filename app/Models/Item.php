<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function sHI()
    {
        return $this->hasMany(StockHistory::class);
    }

    // 🔥 Fungsi untuk mengupdate stok & simpan riwayat stok
    

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            Log::info('Unit sebelum disimpan: ' . $model->unit);
        });

        static::saved(function ($model) {
            Log::info('Unit setelah disimpan: ' . $model->unit);
        });
    }
}
