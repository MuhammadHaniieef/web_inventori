<?php

namespace App\Http\Controllers;

use App\Models\ToolCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ToolCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::id());
        return view('toolscategories.index', ['toolscategories' => ToolCategory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ToolCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);


        return redirect()->route('toolscategories.index')->with('success', 'ToolCategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ToolCategory $toolscategory)
    {
        return view('categories.show', ['ToolCategory' => $toolscategory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToolCategory $toolscategory)
    {
        // return view('categories.edit', ['ToolCategory' => $toolscategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ToolCategory $toolscategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $toolscategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('toolscategories.index')->with('success', 'ToolCategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToolCategory $toolscategory)
    {
        $toolscategory->delete();
        return redirect()->route('toolscategories.index')->with('success', 'ToolCategory deleted successfully.');
    }
}
