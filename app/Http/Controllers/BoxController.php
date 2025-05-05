<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Item;
use App\Models\StockInHistory;
use App\Models\StockOutHistory;
use App\Models\Take;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class BoxController extends Controller
{
    public function index()
    {
        $boxes = Box::all();
        return view('boxes.index', compact('boxes'));
    }

    public function create()
    {
        return view('boxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:boxes,code',
            'description' => 'nullable|string',
            'position' => 'required|string',
            'size' => 'nullable|in:large,medium,small',
        ]);

        Box::create([
            'code' => $request->code,
            'description' => $request->description,
            'position' => $request->position,
            'detail_position' => $request->detail_position,
            'size' => $request->size,
        ]);

        return redirect()->route('boxes.index')->with('success', 'Box created successfully.');
    }

    public function show(Request $request, Box $box)
    {
        // $items = Item::where('box_id', $box->id)->get();
        // return view('boxes.show', compact('box', 'items'));

        // if (!session('qr_scanned_' . $box->id)) {
        // return redirect()->route('welcome')->with('error', 'Akses ditolak! Scan QR terlebih dahulu.');
        // } else {
        // }
        return view('boxes.show', compact('box'));
    }

    public function submitBoxForm(Request $request, Box $box)
    {
        session([
            'name' => $request->name,
            'division' => $request->division,
            'box' => $box->id,
        ]);

        // dd(session()->all());

        return redirect()->route('boxes.details', ['box' => $box]);
    }

    public function showBoxDetails(Box $box)
    {
        if (!session('name') && !session('division')) {
            return redirect()->route('boxes.show', $box->id)->with('error', 'Isi form terlebih dahulu');
        } else {
            $categories = Category::all();
            $boxesList = Box::all();
            $name = session('name');
            $division = session('division');

            $items = Item::where('box_id', $box->id)->get();

            return view('boxes.details', compact('name', 'division', 'items', 'box', 'boxesList', 'categories'));
        }
    }

    public function adminBoxDetails(Box $box)
    {
        if (!Auth::check() && !Auth::user()->roles[0]->id == 1) {
            return redirect()->route('boxes.show', $box->id)->with('error', 'Isi form terlebih dahulu');
        } else {
            $categories = Category::all();
            $boxesList = Box::all();
            $name = session('name');
            $division = session('division');

            $items = Item::where('box_id', $box->id)->get();

            return view('admin.box.details', compact('name', 'division', 'items', 'box', 'boxesList', 'categories'));
        }
    }

    public function BarangUpdate(Request $request)
    {
        foreach ($request->items as $id => $itemData) {
            $item = Item::find($id);
            if ($item) {
                $previousStock = $item->stock;
                $item->update([
                    'name' => $itemData['name'],
                    'stock' => $itemData['stock'],
                    'updated_by' => Auth::user()->name,
                ]);

                StockInHistory::create([
                    'item_id' => $item->id,
                    'previous_stock' => $previousStock,
                    'qty' => $itemData['stock'] - $previousStock,
                    'new_stock' => $itemData['stock'],
                    'type' => 'update',
                    'user_id' => Auth::user()->id,
                ]);
            }
        }


        return redirect()->back()->with('success', 'Updated successfully.');
    }

    public function AmbilBarang(Request $request)
    {
        foreach ($request->items as $itemData) {
            $item = Item::findOrFail($itemData['id']);

            if ($itemData['qty'] > $item->stock) {
                return redirect()->back()->with('error', 'Stok ' . $item->name . ' tidak mencukupi.');
            }

            Take::create([
                'name' => session('name'),
                'division' => session('division'),
                'item_id' => $itemData['id'],
                'qty' => $itemData['qty'],
                'taken_at' => now(),
            ]);

            $previousStock = $item->stock;
            $item->decrement('stock', $itemData['qty']);

            StockOutHistory::create([
                'name' => session('name'),
                'division' => session('division'),
                'item_id' => $item->id,
                'previous_stock' => $previousStock,
                'qty' => $itemData['qty'],
                'new_stock' => $previousStock - $itemData['qty'],
                'type' => 'take',
            ]);
        }
        return redirect()->route('preview')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function edit(Box $box)
    {
        return view('boxes.edit', compact('box'));
    }

    public function update(Request $request, Box $box)
    {
        $request->validate([
            'code' => 'required|string|unique:boxes,code,' . $box->id,
            'description' => 'nullable|string',
            'position' => 'required|string',
            'size' => 'nullable|in:large,medium,small',
        ]);

        $box->update([
            'code' => $request->code,
            'description' => $request->description,
            'position' => $request->position,
            'detail_position' => $request->detail_position,
            'size' => $request->size,
        ]);

        return redirect()->route('boxes.index')->with('success', 'Box updated successfully.');
    }

    public function destroy(Box $box)
    {
        $box->delete();
        return redirect()->route('boxes.index')->with('success', 'Box deleted successfully.');
    }

    // public function generateQrCode($id)
    // {
    //     $box = Box::findOrFail($id);
    //     $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('boxes.show', $box->id)));

    //     return response()->make(base64_decode($qrCode), 200, ['Content-Type' => 'image/png']);
    // }

    // public function downloadQrCode($id)
    // {
    //     $box = Box::findOrFail($id);
    //     $qrCode = QrCode::format('png')->size(200)->generate(route('boxes.show', $box->id));

    //     return response()->streamDownload(function () use ($qrCode) {
    //         echo $qrCode;
    //     }, "qrcode_box_{$box->id}.png");
    // }
}
