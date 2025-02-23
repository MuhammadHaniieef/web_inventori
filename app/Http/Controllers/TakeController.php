<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Take;

class TakeController extends Controller
{
    

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'item_id' => 'required|exists:tools,id',
    //         'qty' => 'required|integer|min:1',
    //     ]);

    //     Take::create([
    //         'name' => session('name'),
    //         'division' => session('division'),
    //         'item_id' => $request->item_id,
    //         'qty' => $request->qty,
    //         'taked_at' => now(),
    //     ]);

    //     // session()->forget(['name', 'division']);

    //     return redirect()->route('preview')->with('success', 'Peminjaman alat berhasil dicatat.');
    // }
}
