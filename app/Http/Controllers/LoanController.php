<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\StockInHistory;
use App\Models\Tool;

use App\Models\StockOutHistory;
use App\Models\ToolCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        return view('loans.dashboard', compact('loans'));
    }

    public function store(Request $request)
    {
        if (!isset($request->tools) || empty($request->tools)) {
            return redirect()->back()->with('error', 'Silakan pilih alat yang ingin dipinjam.');
        }

        foreach ($request->tools as $toolData) {
            if (!isset($toolData['tool_id']) || !isset($toolData['qty'])) {
                continue;
            }

            $tool = Tool::find($toolData['tool_id']);

            if (!$tool) {
                return redirect()->back()->with('error', 'Alat tidak ditemukan.');
            }

            if ($toolData['qty'] > $tool->stock) {
                return redirect()->back()->with('error', 'Stok ' . $tool->name . ' tidak mencukupi.');
            }

            $previousStock = $tool->stock;
            $tool->decrement('stock', $toolData['qty']);

            Loan::create([
                'name' => session('name'),
                'division' => session('division'),
                'tool_id' => $tool->id,
                'phone' => session('phone'),
                'qty' => $toolData['qty'],
                'borrowed_at' => now(),
                'returned' => false,
            ]);

            StockOutHistory::create([
                'name' => session('name'),
                'division' => session('division'),
                'tool_id' => $tool->id,
                'previous_stock' => $previousStock,
                'qty' => $toolData['qty'],
                'new_stock' => $previousStock - $toolData['qty'],
                'type' => 'loan',
            ]);
        }

        return redirect()->route('preview')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function return(Loan $loan)
    {
        $tool = $loan->tool;
        $previousStock = $tool->stock;

        $loan->update([
            'returned' => true,
            'returned_at' => now(),
        ]);

        $tool->increment('stock', $loan->qty);

        // StockInHistory::create([
        //     'tool_id' => $tool->id,
        //     'previous_stock' => $previousStock,
        //     'qty' => $loan->qty,
        //     'new_stock' => $previousStock + $loan->qty,
        //     'type' => 'return',
        //     'user_id' => Auth::user()->id,
        // ]);

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function formSession()
    {
        return view('loans.form-name');
    }

    public function submitFormSession(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'phone' => 'required|string|min:8',
        ], [
            'phone.min' => 'Nomor telepon harus memiliki minimal 8 digit.',
        ]);

        session([
            'name' => $request->name,
            'division' => $request->division,
            'phone' => $request->phone,
        ]);

        return redirect()->route('loans.form-tool');
        // return response()->json(['success' => true]);
    }

    public function takeForm()
    {
        if (!session('name') && !session('division')) {
            return redirect()->route('loans.form-name')->with('error', 'Isi form terlebih dahulu');
        } else {
            $name = session('name');
            $division = session('division');
            $phone = session('phone');
            $tools = Tool::with('tool_category')->get()->groupBy('tool_category.name');
            // $tools = Tool::all();
            return view('loans.form-tool', compact('tools', 'name', 'division', 'phone'));
        }
    }

    // public function approve(Loan $loan)
    // {
    //     if ($loan->status !== 'pending') {
    //         return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
    //     }

    //     $tool = $loan->tool;

    //     if ($loan->qty > $tool->stock) {
    //         return redirect()->back()->with('error', 'Stok tidak mencukupi.');
    //     }

    //     $previousStock = $tool->stock;
    //     $loan->update(['status' => 'approved']);
    //     $tool->decrement('stock', $loan->qty);

    //     StockOutHistory::create([
    //         'tool_id' => $tool->id,
    //         'previous_stock' => $previousStock,
    //         'new_stock' => $previousStock - $loan->qty,
    //         'qty' => $loan->qty,
    //         'picked_by' => $loan->name,
    //         'division' => $loan->division,
    //     ]);

    //     return redirect()->back()->with('success', 'Peminjaman disetujui.');
    // }

    // public function reject(Loan $loan)
    // {
    //     if ($loan->status !== 'pending') {
    //         return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
    //     }

    //     $loan->update(['status' => 'rejected']);

    //     return redirect()->back()->with('success', 'Peminjaman ditolak.');
    // }
}
