<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Chalan;
use App\Models\Dadon;
use App\Models\DadonCollection;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Charge;
use App\Models\Daily;
use App\Models\Customer;
use App\Models\CustomerJoma;
use App\Models\Amanot;
use App\Models\Uttolon;
use App\Models\Cash;
use App\Models\ChalanExpenses;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = date('Y');
        $from = $request->input('from_date');
        $to = $request->input('to_date');
        return $this->loadChart($year, $from, $to);
    }

    public function filterByYear($year)
    {
        return $this->loadChart($year);
    }

    private function loadChart($year, $from, $to)
    {
        $months = ['জানু', 'ফেব', 'মার্চ', 'এপ্রি', 'মে', 'জুন', 'জুলাই', 'আগ', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে'];
        $incomeData = [];
        $expenseData = [];

        for ($i = 1; $i <= 12; $i++) {
            $commission = Chalan::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('commission_amount');
            $charge = Charge::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('total_charge');
            $income = Income::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('amount');
            $expense = Expense::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('amount');

            $incomeData[] = round($income + $commission + $charge, 2);
            $expenseData[] = round($expense, 2);
        }

        // সব available সাল বের করা
        $years = DB::table('incomes')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->union(
                DB::table('expenses')->select(DB::raw('YEAR(created_at) as year'))
            )
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // total income
        $income     = Helper::sum(Income::class, 'amount', 'date', $from, $to);
        $commission = Helper::sum(Chalan::class, 'commission_amount', 'chalan_date', $from, $to);
        $charge     = Helper::sum(Charge::class, 'total_charge', 'date', $from, $to);

        $total_income = $income + $commission + $charge;

        // expense
        $total_expense = Helper::sum(Expense::class, 'amount', 'date', $from, $to);

        //total commision
        $chalan_expense = ChalanExpenses::query()
            ->when($from && $to, fn($q) => $q->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]))
            ->when($from && !$to, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to && !$from, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->sum('amount');
        $total_commission = $commission + $charge + $chalan_expense;

        // baki
        $total_baki = Helper::sum(Dadon::class, 'total_given_amount', 'given_date', $from, $to);

        // baki aday
        $total_baki_aday = Helper::sum(DadonCollection::class, 'collection_amount', 'collection_date', $from, $to);

        // paikar baki
        $totalDailyKroy = Helper::sum(Daily::class, 'total_amount', 'chalan_date', $from, $to);
        $totalJer       = Helper::sum(Customer::class, 'jer', 'created_at', $from, $to);
        $totalPayment   = Helper::sum(Daily::class, 'payment_amount', 'chalan_date', $from, $to);
        $totalJoma      = Helper::sum(CustomerJoma::class, 'jomartaka', 'jomardate', $from, $to);

        $totalDailyKroyWithCharge = $totalDailyKroy + $charge + $totalJer;
        $totalJomaWithPayment     = $totalJoma + $totalPayment;

        $totalBaki = $totalJomaWithPayment - $totalDailyKroyWithCharge;


        // amanot
        $total_amount = Helper::sum(Chalan::class, 'total_amount', 'chalan_date', $from, $to);
        $payment_amount = Helper::sum(Chalan::class, 'payment_amount', 'chalan_date', $from, $to);
        $amanot_amount = Helper::sum(Amanot::class, 'amount', 'date', $from, $to);

        $totalamanot = ($total_amount - $payment_amount) + $amanot_amount;


        //uttolon
        $uttolon_amount = Helper::sum(Uttolon::class, 'amount', 'date', $from, $to);

        //cash
        $totalcash = Cash::latest()->value('cash');


        return view('dashboard', compact('from','to','months', 'incomeData', 'expenseData', 'year', 'years','total_income','total_expense','total_baki','total_baki_aday','total_commission','totalBaki','totalamanot','uttolon_amount','totalcash','totalJoma'));
    }



    
}
