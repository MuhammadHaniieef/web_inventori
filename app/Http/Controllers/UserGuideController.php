<?php

namespace App\Http\Controllers;

use App\Models\UserGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserGuideController extends Controller
{
    public function index()
    {
        $uGuides = UserGuide::all();
        return view('user-guide', compact('uGuides'));
    }

    // Mengupload file PDF
    public function upload(Request $request)
    {
        $request->validate([
            'user_guide' => 'required|mimes:pdf|max:8192',
        ]);

        $file = $request->file('user_guide');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uGuides', $fileName, 'public');

        $u = UserGuide::create([
            'name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
        ]);

        // dd($u);

        return redirect()->back()->with('success', 'File berhasil diupload!');
    }

    // Menampilkan file PDF
    public function view($id)
    {
        $uGuide = UserGuide::findOrFail($id);
        $filePath = storage_path('app/public/' . $uGuide->file_path);
        return response()->file($filePath);
    }

    // Mengunduh file PDF
    public function download($id)
    {
        $uGuide = UserGuide::findOrFail($id);
        $filePath = storage_path('app/public/' . $uGuide->file_path);
        return response()->download($filePath, $uGuide->name);
    }

    public function delete($id)
    {
        $uGuide = UserGuide::findOrFail($id);

        Storage::disk('public')->delete($uGuide->file_path);

        $uGuide->delete();

        return redirect()->back()->with('success', 'Panduan berhasil dihapus!');
    }
}
