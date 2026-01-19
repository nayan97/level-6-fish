<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Daily;
use App\Models\Customer;
use App\Models\CustomerJoma;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('backend.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('backend.customer.add');
    }

public function store(Request $request)
{
    $request->validate([
        'name'   => 'required',
        'phone'  => 'nullable|unique:customers',
        'address'=> 'nullable',
        'jer'    => 'numeric|min:0',
    ]);

    // Create customer
    $customer = Customer::create($request->all());

    // If request expects JSON (AJAX or API)
    if ($request->wantsJson()) {
        return response()->json([
            'status'   => true,
            'customer' => $customer
        ]);
    }

    // Normal web form redirect
    return redirect()->back()->with('success', 'কাস্টমার সফলভাবে তৈরি হয়েছে!');
}


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.customer.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $customer = Customer::findOrFail($request->id);

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'jer' => $request->jer,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')->with('success', 'কাস্টমার সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'কাস্টমার সফলভাবে ডিলিট হয়েছে!');
    }


    public function storeAjax(Request $request)
    {

        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'nullable|string|max:500',
            'jer' => 'nullable|numeric|min:0',
        ]);

        try {
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'jer' => $request->jer,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'গ্রাহক সফলভাবে যোগ করা হয়েছে!',
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                ]
            ]);
        } catch (Exception $e) {
            \Log::error('Error creating customer via AJAX: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'গ্রাহক যোগ করতে একটি অপ্রত্যাশিত সমস্যা হয়েছে। অনুগ্রহ করে লগ চেক করুন।',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }


public function jomaList(Request $request)
{
    $fromDate = Carbon::today()->startOfDay();
    $toDate   = Carbon::today()->endOfDay();

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $toDate   = Carbon::parse($request->to_date)->endOfDay();
    }

    $customerJomas = CustomerJoma::with('customer')
        ->whereBetween('created_at', [$fromDate, $toDate])
        ->latest()
        ->get();

    return view('backend.customer.jomatalika', compact('customerJomas', 'fromDate', 'toDate'));
}

    public function jomaCreate()
    {
        $customers = Customer::all();
        return view('backend.customer.jomaadd', compact('customers'));
    }
    public function getCustomerBalance($id)
    {
        $customer = Customer::findOrFail($id);
        // $customer=Daily::where('customer_id',$id)->sum('due');
        // dd($customer->balance);

        return response()->json([
            'balance' => abs($customer->balance),
        ]);
    }


        public function jomastore(Request $request)
        {
            // Validate with correct field names (match your form)
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'jomardate' => 'required|date',
        ]);

        // ✅ discount_amount default 0
        $discount = $validated['discount_amount'] ?? 0;
        
        // ✅ amount = amount + discount_amount
        $finalAmount = $validated['amount'] + $discount;
        
        $formattedDate = Carbon::parse($request->jomardate)->format('Y-m-d');
        // dd($discount);

        CustomerJoma::create([
            'customer_id' => $validated['customer_id'],
            'jomartaka' => $finalAmount,  // 🔥 এখানে final amount save হবে
            'discount_amount' => $discount,
            'jomardate' => $formattedDate,
            'user_id' => auth()->id(), 
        ]);




            // Update cash
            $latestCash = Cash::latest()->first();
            if ($latestCash) {
                $latestCash->increment('cash', $validated['amount'],);
            }

            return redirect()->route('customers_joma.index')->with('success', 'জমা সফলভাবে তৈরি হয়েছে!');
        }


    public function jomaDestroy($id)
    {
        $customerJoma = CustomerJoma::findOrFail($id);
        $customerJoma->delete();
        return redirect()->route('customers_joma.index')->with('success', 'জমা সফলভাবে ডিলিট হয়েছে!');
    }
    
}
