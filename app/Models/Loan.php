<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function updateStock($userId, $qty, $type)
    // {
    //     $previousStock = $this->stock;
    //     $newStock = ($type === 'increase') ? $previousStock + $qty : $previousStock - $qty;

    //     // Cegah stok negatif
    //     if ($newStock < 0) {
    //         return false;
    //     }

    //     // Simpan perubahan stok
    //     $this->stock = $newStock;
    //     $this->save();

    //     // Catat riwayat perubahan stok
    //     StockHistory::create([
    //         'item_id' => $this->id,
    //         'user_id' => $userId,
    //         'previous_stock' => $previousStock,
    //         'new_stock' => $newStock,
    //         'qty' => $qty,
    //         'type' => $type,
    //     ]);

    //     return true;
    // }
}
