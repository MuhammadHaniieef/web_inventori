<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateStock($userId, $quantity, $type)
    {
        $previousStock = $this->stock;
        $newStock = ($type === 'increase') ? $previousStock + $quantity : $previousStock - $quantity;

        // Cegah stok negatif
        if ($newStock < 0) {
            return false;
        }

        // Simpan perubahan stok
        $this->stock = $newStock;
        $this->save();

        // Catat riwayat perubahan stok
        StockHistory::create([
            'item_id' => $this->id,
            'user_id' => $userId,
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'quantity' => $quantity,
            'type' => $type,
        ]);

        return true;
    }
}
