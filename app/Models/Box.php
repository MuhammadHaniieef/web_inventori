<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Box extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getQrCodeAttribute()
    {
        $items = Item::all();
        return QrCode::size(200)->generate(route('boxes.show', $this->id));
    }
}
