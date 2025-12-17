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
                'name'    => 'required',
                'phone'   => 'nullable|unique:mohajons',
                'address' => 'nullable',
            ]);

            // Create Mohajon
            $mohajon = Mohajon::create($request->all());

            // If request expects JSON (for AJAX)
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => true,
                    'mohajon' => $mohajon
                ]);
            }

            // Normal web form redirect
            return redirect()->back()->with('success', 'মহাজন সফলভাবে তৈরি হয়েছে!');
        }


        public function storeAjax(Request $request)
        {
            $validator = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20|unique:mohajons,phone',
                'address' => 'nullable|string|max:500',
            ]);

            try {
                $mohajon = Mohajon::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'মহাজন সফলভাবে যোগ করা হয়েছে!',
                    'mohajon' => [
                        'id' => $mohajon->id,
                        'name' => $mohajon->name,
                    ]
                ]);

            } catch (\Exception $e) {
                \Log::error('Error creating Mohajon via AJAX: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'মহাজন যোগ করতে সমস্যা হয়েছে। অনুগ্রহ করে লগ চেক করুন।',
                    'error_details' => $e->getMessage()
                ], 500);
            }
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
