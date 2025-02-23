<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockInHistory;
use App\Models\StockOutHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $user = Auth::user();
    //     $role = $user->roles[0]->name;
    //     return view('dashboard', compact('user', 'role'));
    // }

    public function previewPage()
    {
        $frequentlyOut = StockOutHistory::selectRaw('item_id, tool_id, COUNT(*) as total')
            ->groupBy('item_id', 'tool_id')
            ->limit(8)
            ->get();

        $newlyAdded = StockInHistory::where('type', 'new')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $sInHistories = StockInHistory::all();
        $sOutHistories = StockOutHistory::all();

        $inItems = Item::where('status', 'waiting')->get();

        return view('preview', compact('sInHistories', 'sOutHistories', 'frequentlyOut', 'newlyAdded', 'inItems'));
    }
}
