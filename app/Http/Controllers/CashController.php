<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cash;
use App\Models\Chalan;
use App\Models\Amanot;
use App\Models\Daily;
use App\Models\Customer;
use App\Models\CustomerJoma;
use App\Models\Charge;
use App\Models\CashExpense;
use App\Models\ChalanExpenses;
use Carbon\Carbon;

class CashController extends Controller
{
    public function index()
    {

        $cashs = Cash::orderBy('id', 'desc')->get();

        return view('backend.cash.index', compact('cashs'));

    }

    public function create()
    {
        // amanot
        $total_amount = Chalan::whereDate('chalan_date', Carbon::today())->sum('total_amount');
        $payment_amount = Chalan::whereDate('chalan_date', Carbon::today())->sum('payment_amount');
        $amanot_amount = Amanot::whereDate('date', Carbon::today())->sum('amount');

        $todayamanot = ($total_amount - $payment_amount) + $amanot_amount;

        // today commision
        $commission     = Chalan::whereDate('chalan_date', Carbon::today())->sum('commission_amount');
        $charge         = Charge::whereDate('date', Carbon::today())->sum('total_charge');
        $chalan_expense = ChalanExpenses::whereDate('created_at', Carbon::today())->sum('amount');

        $todaycommission = $commission + $charge + $chalan_expense;


        // gotokaler paikar baki
        $totalDailyKroy = Daily::whereDate('chalan_date', Carbon::yesterday())->sum('total_amount');
        $totalJer       = Customer::whereDate('created_at', Carbon::yesterday())->sum('jer');
        $totalPayment   = Daily::whereDate('chalan_date', Carbon::yesterday())->sum('payment_amount');
        $totalJoma      = CustomerJoma::whereDate('jomardate', Carbon::yesterday())->sum('jomartaka');
        $charge         = Charge::whereDate('date', Carbon::yesterday())->sum('total_charge');

        $totalDailyKroyWithCharge = $totalDailyKroy + $charge + $totalJer;
        $totalJomaWithPayment     = $totalJoma + $totalPayment;

        $gotokalerpaikarBaki = abs($totalJomaWithPayment - $totalDailyKroyWithCharge);

        //cash
        $totalcash = Cash::latest()->value('cash');

        return view('backend.cash.add',compact('todayamanot','todaycommission','gotokalerpaikarBaki','totalcash'));
    }


    public function show($id)
    {
        $cashEntry = Cash::with('expenses')->findOrFail($id);

        // dd($cashEntry);

        return view('backend.cash.show', compact('cashEntry'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'cash' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'goto_kaler_baki' => 'nullable|numeric',
            'ajker_amanot' => 'nullable|numeric',
            'left_side_total' => 'required|numeric',
            'khoroch_side_total' => 'required|numeric',
            'khoroch_details' => 'required|array',
            'khoroch_details.*' => 'nullable|string|max:255',
            'khoroch_amount' => 'required|array',
            'khoroch_amount.*' => 'nullable|numeric',
        ]);

        $cash = ($request->left_side_total - $request->khoroch_side_total);

        $cashEntry = Cash::create([
            'cash' => $cash,
            'today_commisoin' => $request->commission,
            'pre_day_paikar_due' => $request->goto_kaler_baki,
            'today_amount' => $request->ajker_amanot,
            'total_amanot' => $request->left_side_total,
        ]);


        foreach ($request->khoroch_details as $index => $details) {
        
            $amount = $request->khoroch_amount[$index];
                if ($details && $amount) {
                    $expense = new CashExpense();
                    $expense->cash_id = $cashEntry->id;
                    $expense->name = $details;
                    $expense->amount = $amount;
                    $expense->save();
                }
        }

        return redirect()->route('cash.index')->with('success', 'cash added successfully.');
    }

    public function destroy($id)
    {
        $cash = Cash::findOrFail($id);
        $cash->delete();

        return redirect()->route('cash.index')->with('success', 'cash deleted successfully.');
    }
}
