<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\CashAdd;
use Illuminate\Http\Request;

class CashAddController extends Controller
{
    // Show list
    public function index()
    {
        $cashAdds = CashAdd::orderBy('id', 'desc')->get();
        return view('backend.cashadd.index', compact('cashAdds'));
    }

    // Show create form
    public function create()
    {
        return view('backend.cashadd.add');
    }

    // Store data
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
        ]);

        CashAdd::create([
            'amount' => $request->amount,
            'date'   => $request->date,
        ]);

        Cash::latest()->first()?->increment('cash', $request->amount);


        return redirect()
            ->route('cashadd.index')
            ->with('success', 'Cash added successfully.');
    }

    // Delete
    public function destroy($id)
    {
        $cashAdd = CashAdd::findOrFail($id);
        $cashAdd->delete();

        return redirect()
            ->route('cashadd.index')
            ->with('success', 'Cash deleted successfully.');
    }
}
