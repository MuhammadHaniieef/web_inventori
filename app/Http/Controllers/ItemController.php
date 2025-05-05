<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Item;
use App\Models\Category;
use App\Models\Loan;
use App\Models\StockInHistory;
use App\Models\StockOutHistory;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // Hitung total data
        $userCount = User::count();
        $itemCount = Item::count();
        $toolCount = Tool::count();

        // Ambil data Item dan Tool dengan pagination
        $items = Item::with('category')->paginate(10);
        $tools = Tool::with('tool_category')->paginate(10);
        $ins = Item::where('status', 'waiting')->paginate(10);

        // Data barang yang sering keluar
        $frequentlyOut = StockOutHistory::selectRaw('item_id, tool_id, COUNT(*) as total')
            ->groupBy('item_id', 'tool_id')
            ->limit(10)
            ->get();

        // Ambil bulan yang dipilih (default: bulan ini)
        $selectedMonth = $request->input('selected_month', now()->format('Y-m'));

        // Query untuk data barang masuk (Item)
        $stockInItems = StockInHistory::query()
            ->whereYear('created_at', date('Y', strtotime($selectedMonth)))
            ->whereMonth('created_at', date('m', strtotime($selectedMonth)))
            ->selectRaw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as period, COUNT(DISTINCT item_id) as total')
            ->groupBy('period')
            ->get();

        // Query untuk data barang masuk (Tool)
        $stockInTools = StockInHistory::query()
            ->whereYear('created_at', date('Y', strtotime($selectedMonth)))
            ->whereMonth('created_at', date('m', strtotime($selectedMonth)))
            ->selectRaw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as period, COUNT(DISTINCT tool_id) as total')
            ->groupBy('period')
            ->get();

        // Query untuk data barang keluar (Item)
        $stockOutItems = StockOutHistory::query()
            ->whereYear('created_at', date('Y', strtotime($selectedMonth)))
            ->whereMonth('created_at', date('m', strtotime($selectedMonth)))
            ->selectRaw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as period, COUNT(DISTINCT item_id) as total')
            ->groupBy('period')
            ->get();

        // Query untuk data barang keluar (Tool)
        $stockOutTools = StockOutHistory::query()
            ->whereYear('created_at', date('Y', strtotime($selectedMonth)))
            ->whereMonth('created_at', date('m', strtotime($selectedMonth)))
            ->selectRaw('WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as period, COUNT(DISTINCT tool_id) as total')
            ->groupBy('period')
            ->get();

        return view('dashboard', compact(
            'items',
            'tools',
            'ins',
            'toolCount',
            'itemCount',
            'userCount',
            'frequentlyOut',
            'stockInItems',
            'stockInTools',
            'stockOutItems',
            'stockOutTools',
            'selectedMonth'
        ));
    }

    public function indexItem()
    {
        $items = Item::all();

        // dd($items);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $boxes = Box::all();
        return view('items.create', compact('categories', 'boxes'));
    }

    public function show()
    {
        // 
    }

    public function iBarangDatang()
    {
        $items = Item::where('status', 'waiting')->paginate(50);
        $boxes = Box::all();

        // dd($items);
        return view('items.in', compact('items', 'boxes'));
    }

    public function processAssignMultipleToBox(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
            'box_id' => 'required|exists:boxes,id',
        ]);

        Item::whereIn('id', $request->item_ids)->update([
            'box_id' => $request->box_id,
            'status' => 'assigned',
        ]);

        return redirect()->route('iBrgDtg')->with('success', 'Barang berhasil ditetapkan ke box!');
    }


    public function cBarangDatang()
    {
        $categories = Category::all();
        return view('items.in-create', compact('categories'));
    }

    public function sBarangDatang(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/items', 'public');
            // $imagePath = str_replace('public/', '', $imagePath);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        // $imagePath = $request->file('image')->store('profile_pictures', 'public');
        //     $user->image = $imagePath;

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'image_path' => $imagePath,
            'status' => 'waiting',
            'created_by' => Auth::user()->name ?? '-',
            'updated_by' => Auth::user()->name ?? '-',
        ]);

        StockInHistory::create([
            'item_id' => $item->id,
            'previous_stock' => 0,
            'qty' => $request->stock,
            'new_stock' => $request->stock,
            'type' => 'new',
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Item berhasil ditambahkan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'box_id' => 'nullable|exists:boxes,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/items', 'public');
            // $imagePath = str_replace('public/', '', $imagePath);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        // $imagePath = $request->file('image')->store('profile_pictures', 'public');
        //     $user->image = $imagePath;

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'box_id' => $request->box_id,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'image_path' => $imagePath,
            'status' => 'assigned',
            'created_by' => Auth::user()->name ?? '-',
            'updated_by' => Auth::user()->name ?? '-',
        ]);

        StockInHistory::create([
            'item_id' => $item->id,
            'previous_stock' => 0,
            'qty' => $request->stock,
            'new_stock' => $request->stock,
            'type' => 'new',
            'user_id' => Auth::user()->id,
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
            'box_id' => 'nullable|exists:boxes,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $imagePath = $item->image_path;

        if ($request->hasFile('image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $imagePath = $request->file('image')->store('images/items', 'public');
            // $imagePath = str_replace('public/', '', $imagePath);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $previousStock = $item->stock;

        $updated = $item->forceFill([
            'name' => $request->name,
            'description' => $request->description,
            'box_id' => $request->box_id,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'image_path' => $imagePath,
            'updated_by' => Auth::user()->name ?? '-',
        ])->save();

        if ($previousStock !== (int) $request->stock) {
            StockInHistory::create([
                'item_name' => $request->name,
                'previous_stock' => $previousStock,
                'qty' => $request->stock,
                'new_stock' => $request->stock,
                'type' => 'update',
                'user_id' => Auth::user()->id,
            ]);
        }

        // dd($updated); // Harus true kalau berhasil        

        return redirect()->route('dashboard')->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('dashboard')->with('success', 'Item berhasil dihapus!');
    }
}
