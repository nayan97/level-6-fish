<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Daily;
use App\Models\Mohajon;
use App\Models\Product;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use DB;

class DailyController extends Controller
{

    public function index(Request $request)
    {
        $query = Daily::with('mohajon');
        // $query = Daily::with('mohajon');
        // dd($query);

        if ($request->has('from_date') && $request->from_date != '' && $request->has('to_date') && $request->to_date != '') {
            
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            $query->whereBetween('chalan_date', [$fromDate, $toDate]);

        } else {

            $fromDate = Carbon::today('Asia/Dhaka')->toDateString();
            $toDate = Carbon::today('Asia/Dhaka')->toDateString();
            $query->whereDate('chalan_date', Carbon::today('Asia/Dhaka'));
        }

            $dailyKroy = $query->select(
                    'mohajon_id',
                    'created_at',
                    'status',
                    DB::raw('SUM(total_amount) as total_amount')
                )
                ->groupBy('mohajon_id', 'created_at', 'status')
                ->with('mohajon')
                ->orderBy('created_at', 'desc')
                ->get();


        $totalSum = $dailyKroy->sum('total_amount');

        return view('backend.daily.index', compact('dailyKroy', 'fromDate', 'toDate', 'totalSum'));
    }

    public function create()
    {
        $customers = Customer::all();
        $mohajons = Mohajon::all();
        $products = Product::all();

        return view('backend.daily.create', compact('customers','mohajons','products'));
    }


        public function store(Request $request)
        {
            $validatedData = $request->validate([
                // Customer Validation
                'mohajon_id' => 'required|exists:mohajons,id',
                'chalan_date' => 'required|date',

                // Product Items Validation
                'items' => 'required|array|min:1',
                'items.*.paikar_name' => 'required|string|max:255',
                'items.*.item_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
                'items.*.payment_amount' => 'numeric|min:0',
            ]);

            $date = $validatedData['chalan_date'];
            $mohajonId = $validatedData['mohajon_id'];

            $chalanItemsData = []; // <-- Must initialize array

            foreach ($validatedData['items'] as $item) {

                $itemQuantity   = (float) $item['quantity'];
                $itemUnitPrice  = (float) $item['unit_price'];
                $payment        = (float) ($item['payment_amount'] ?? 0);

                $finalItemTotal = $itemQuantity * $itemUnitPrice;
                $dueAmount      = $finalItemTotal - $payment;

                $chalanItemsData[] = [
                    'mohajon_id'      => $mohajonId,
                    'customer_id'     => $item['paikar_name'],
                    'product_id'      => $item['item_name'],
                    'chalan_date'     => $date,
                    'quantity'        => $itemQuantity,
                    'amount'          => $itemUnitPrice,
                    'total_amount'    => $finalItemTotal,
                    'payment_amount'  => $payment,
                    'due'             => $dueAmount,        // <-- NEW FIELD
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }

            Daily::insert($chalanItemsData);

            return redirect()->route('daily.index')->with('success', 'দৈনিক ক্রয় সফলভাবে তৈরি হয়েছে!');
        }


    public function destroy($id)
    {
        $daily = Daily::find($id);

        if (!$daily) {
            return redirect()->route('daily.index')->with('error', 'দৈনিক ক্রয় আইটেমটি পাওয়া যায়নি।');
        }

        $daily->delete();

    }

    public function destroyByDate($mohajon_id, $date)
    {
        Daily::where('mohajon_id', $mohajon_id)
            ->where('created_at', $date)
            ->delete();

        return redirect()->route('daily.index')->with('success', 'সফলভাবে মুছে ফেলা হয়েছে।');
    }


    public function kroyhishab(Request $request)
    {
        $query = Daily::with(['customer', 'mohajon', 'product']);

        if ($request->has('from_date') && $request->from_date != '' && $request->has('to_date') && $request->to_date != '') {
            
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            $query->whereBetween('chalan_date', [$fromDate, $toDate]);

        } else {

            $fromDate = Carbon::today('Asia/Dhaka')->toDateString();
            $toDate = Carbon::today('Asia/Dhaka')->toDateString();
            $query->whereDate('chalan_date', Carbon::today('Asia/Dhaka'));
        }

        $dailyKroy = $query->latest('chalan_date')->get();
        $totalSum = $dailyKroy->sum('total_amount');
        $totalQty = $dailyKroy->sum('quantity');

        return view('backend.daily.kroyhishab', compact('dailyKroy', 'fromDate', 'toDate', 'totalSum','totalQty'));
    }


public function chargeCalculate(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:dailies,id',
        'paikar_id' => 'required|exists:customers,id',
        'total_qty' => 'required|numeric|min:0', 
        'charge_per_kg' => 'required|numeric|min:0',
        'total_charge' => 'required|numeric|min:0',
        'date' => 'nullable|date',
    ]);

    //dd($request->all());

    // 1. Create Charge
    Charge::create($request->only([
       'order_id', 'paikar_id', 'total_qty', 'charge_per_kg', 'total_charge', 'date'
    ]));

    // 2. Update Daily model
$daily = Daily::find($request->order_id);

if ($daily) {
    $daily->update([
        'set_charged' => $daily->set_charged + $request->total_qty,
        'due' => $daily->due + $request->total_charge
    ]);
}


    return back()->with('success', 'পাইকার চার্জ সফলভাবে সংরক্ষণ হয়েছে।');
}




    public function getPaikarChargeSum(Request $request)
    {
        $paikarIds = $request->paikar_ids; // filtered paikar ids
        $from = $request->from_date;
        $to = $request->to_date;

        // charge sum for filtered paikars
        $jer = DB::table('customers')
            ->whereIn('id', $paikarIds)
            ->sum('jer');

        $chargeAmount = DB::table('charges')
            ->whereIn('paikar_id', $paikarIds)
            ->whereBetween('date', [$from, $to])
            ->sum('total_charge');

        return response()->json([
            'jer' => $jer,
            'charge_amount' => $chargeAmount
        ]);
    }

    public function PaikarChargeList(Request $request)
    {

        $chargeLists = Charge::all();
        return view('backend.reports.charge_list', compact('chargeLists'));

    }


}
