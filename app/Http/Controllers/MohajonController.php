<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mohajon;

class MohajonController extends Controller
{
    public function index()
    {
        $mohajons = Mohajon::latest()->paginate(20);
        return view('backend.mohajon.index', compact('mohajons'));
    }

    public function create()
    {
        return view('backend.mohajon.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable|unique:customers',
            'address' => 'nullable',
        ]);

        Mohajon::create($request->all());

        return redirect()->back()->with('success', 'মহাজন সফলভাবে তৈরি হয়েছে!');
    }

    public function edit($id)
    {
        $mohajon = Mohajon::findOrFail($id);
        return view('backend.mohajon.edit', compact('mohajon'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $mohajon = Mohajon::findOrFail($request->id);

        $mohajon->update([
            'name' => $request->name,
            'phone' => $request->phone,
            // 'balance' => $request->balance,
            'address' => $request->address,
        ]);

        return redirect()->route('mohajons.index')->with('success', 'মহাজন সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $mohajon = Mohajon::findOrFail($id);
        $mohajon->delete();
        return redirect()->route('mohajons.index')->with('success', 'মহাজন সফলভাবে ডিলিট হয়েছে!');
    }
}
