<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Item;
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
            'type' => 'nullable|in:plastic,alumunium,iron,cardboard',
            'size' => 'nullable|in:large,medium,small',
        ]);

        Box::create([
            'code' => $request->code,
            'description' => $request->description,
            'position' => $request->position,
            'detail_position' => $request->detail_position,
            'type' => $request->type,
            'size' => $request->size,
        ]);

        return redirect()->route('boxes.index')->with('success', 'Box created successfully.');
    }

    public function show(Box $box)
    {
        $items = Item::where('box_id', $box->id)->get();

        return view('boxes.show', compact('box', 'items'));
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
            'type' => 'nullable|in:plastic,alumunium,iron,cardboard',
            'size' => 'nullable|in:large,medium,small',
        ]);

        $box->update([
            'code' => $request->code,
            'description' => $request->description,
            'position' => $request->position,
            'detail_position' => $request->detail_position,
            'type' => $request->type,
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
