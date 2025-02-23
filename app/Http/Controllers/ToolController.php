<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StockInHistory;
use App\Models\Tool;
use App\Models\ToolCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::all();
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = ToolCategory::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/tools', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $tool = Tool::create([
            'name' => $request->name,
            'description' => $request->description,
            'tool_category_id' => $request->tool_category_id,
            'stock' => $request->stock,
            'created_by' => Auth::user()->name ?? '-',
            'image_path' => $imagePath,
        ]);

        StockInHistory::create([
            'tool_id' => $tool->id,
            'previous_stock' => 0,
            'qty' => $request->stock,
            'new_stock' => $request->stock,
            'type' => 'new',
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Tool $tool)
    {
        $categories = ToolCategory::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tool_category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $imagePath = $tool->image_path;

        if ($request->hasFile('image')) {
            if ($tool->image_path && Storage::disk('public')->exists($tool->image_path)) {
                Storage::disk('public')->delete($tool->image_path);
            }
            $imagePath = $request->file('image')->store('images/tools', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $tool->update([
            'name' => $request->name,
            'description' => $request->description,
            'tool_category_id' => $request->tool_category_id,
            'stock' => $request->stock,
            'image_path' => $imagePath,
            'updated_by' => Auth::user()->name ?? '-',
        ]);

        return redirect()->back()->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        if ($tool->image_path && Storage::disk('public')->exists($tool->image_path)) {
            Storage::disk('public')->delete($tool->image_path);
        }

        $tool->delete();
        return redirect()->back()->with('success', 'Alat berhasil dihapus.');
    }
}
