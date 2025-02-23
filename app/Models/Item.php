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

    // public function sHI()
    // {
    //     return $this->hasMany(StockHistory::class);
    // }

    // 🔥 Fungsi untuk mengupdate stok & simpan riwayat stok

    public function takes()
    {
        return $this->hasMany(Take::class, 'item_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
