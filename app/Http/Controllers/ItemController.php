<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Item;
use App\Models\Category;
use App\Models\Loan;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->paginate(50);
        $loans = Loan::all();
        return view('dashboard', compact('items', 'loans'));
    }

    public function sHistories()
    {
        $sHistories = StockHistory::all();
        return view('stocks.histories', compact('sHistories'));
    }

    public function create()
    {
        $categories = Category::all();
        $boxes = Box::all();
        return view('items.create', compact('categories', 'boxes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'box_id' => 'nullable|exists:boxes,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'requires_approval' => 'required|boolean'
        ]);

        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'box_id' => $request->box_id,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'requires_approval' => $request->requires_approval
        ]);

        return redirect()->route('dashboard')->with('success', 'Item berhasil ditambahkan!');
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        $boxes = Box::all();
        return view('items.edit', compact('item', 'categories', 'boxes'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'box_id' => 'nullable|exists:boxes,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'requires_approval' => 'required|boolean'
        ]);

        $updated = $item->forceFill([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'box_id' => $request->box_id,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'updated_by' => Auth::id(),
            'requires_approval' => $request->requires_approval
        ])->save();

        // dd($updated); // Harus true kalau berhasil        

        return redirect()->route('dashboard')->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('dashboard')->with('success', 'Item berhasil dihapus!');
    }
}
