<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Item;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'type' => 'required|in:ambil,pinjam',
            'guest_name' => 'nullable|string|max:255',
            'division' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($request->qty > $item->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $status = (!$item->requires_approval) ? 'approved' : 'pending';

        $loan = Loan::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::check() ? Auth::id() : null,
            'guest_name' => $request->guest_name,
            'division' => $request->division,
            'phone' => $request->phone,
            'qty' => $request->qty,
            'type' => $request->type,
            'borrowed_at' => now(),
            'status' => $status,
        ]);

        if ($status === 'approved') {
            $previousStock = $item->stock;
            $item->decrement('stock', $request->qty);

            StockHistory::create([
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'previous_stock' => $previousStock,
                'new_stock' => $previousStock - $request->qty,
                'quantity' => $request->qty,
                's_type' => 'decrease',
                't_type' => $request->type,
            ]);
        }

        return redirect()->route('welcome')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
        }

        if ($loan->qty > $loan->item->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $previousStock = $loan->item->stock;
        $loan->update(['status' => 'approved']);
        $loan->item->decrement('stock', $loan->qty);

        StockHistory::create([
            'item_id' => $loan->item->id,
            'user_id' => Auth::id(),
            'previous_stock' => $previousStock,
            'new_stock' => $previousStock - $loan->qty,
            'quantity' => $loan->qty,
            's_type' => 'decrease',
            't_type' => $loan->type,
        ]);

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function return(Loan $loan)
    {
        if ($loan->status !== 'approved' || $loan->type !== 'pinjam') {
            return redirect()->back()->with('error', 'Barang belum disetujui atau bukan barang pinjaman.');
        }

        $previousStock = $loan->item->stock;
        $loan->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $loan->item->increment('stock', $loan->qty);

        StockHistory::create([
            'item_id' => $loan->item->id,
            'user_id' => Auth::id(),
            'previous_stock' => $previousStock,
            'new_stock' => $previousStock + $loan->qty,
            'quantity' => $loan->qty,
            's_type' => 'increase',
            't_type' => 'pinjam',
            'returned' => true,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
        }

        $loan->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }
}
