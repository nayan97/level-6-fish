<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Cash;
use App\Models\Dadon;
use App\Models\Amanot;
use App\Models\Chalan;
use App\Models\Charge;
use App\Models\Income;
use App\Helpers\Helper;
use App\Models\Expense;
use App\Models\Uttolon;
use App\Models\AmanotReturn;
use Illuminate\Http\Request;
use App\Models\ChalanExpenses;
use App\Models\DadonCollection;

class ContentController extends Controller
{

    //Income

    public function income()
    {

        $incomes = Income::orderBy('id', 'desc')->get();

        return view('backend.income.index', compact('incomes'));

    }

    public function income_create()
    {

        return view('backend.income.add');
    }


    public function income_store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        Income::create([
            'source' => $request->source,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('income.index')->with('success', 'Income added successfully.');
    }

    public function income_destroy($id)
    {
        $income = Income::findOrFail($id);
        $income->delete();

        return redirect()->route('income.index')->with('success', 'Income deleted successfully.');
    }

    //Amanot

    public function amanot()
    {

        $amanots = Amanot::orderBy('id', 'desc')->get();

        return view('backend.amanot.index', compact('amanots'));

    }

    public function amanot_create()
    {

        return view('backend.amanot.add');
    }


    public function amanot_store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        
         $latestCash = Cash::latest()->first();  

          $latestCash->cash += $request->amount;  

            $latestCash->save();                 


        Amanot::create([
            'source' => $request->source,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('amanot.index')->with('success', 'Amanot added successfully.');
        
    }

            
    
    
    // amanot return

        public function returnAmount(Request $request, $id)
        {
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'note'   => 'nullable|string',
            ]);

            $amanot = Amanot::findOrFail($id);

            if ($request->amount > $amanot->amount) {
                return response()->json([
                    'message' => 'Return amount cannot be greater than stored amount'
                ], 422);
            }

            // Reduce main amanot amount
            $amanot->amount -= $request->amount;

            // Decode JSON to array
            $returns = json_decode($amanot->return_amounts, true);

            if (!is_array($returns)) {
                $returns = [];
            }

            $returns[] = (float) $request->amount;

            $amanot->return_amounts = json_encode($returns);
            $amanot->save();


            /* ------------------------------------------------
            | Generate Next Step (1st, 2nd, 3rd Installment...)
            ------------------------------------------------ */
            $count = AmanotReturn::where('amanot_id', $amanot->id)->count();
            $next = $count + 1;

            // Generate correct suffix
            $suffix = "th";
            if ($next % 10 == 1 && $next != 11) $suffix = "st";
            if ($next % 10 == 2 && $next != 12) $suffix = "nd";
            if ($next % 10 == 3 && $next != 13) $suffix = "rd";

            $stepText = $next . $suffix . " Installment";


            /* ------------------------------------------------
            | Save History
            ------------------------------------------------ */
            AmanotReturn::create([
                'amanot_id' => $amanot->id,
                'amount'    => $request->amount,
                'note'      => $request->note,
                'date'      => now(),
                'step'      => $stepText,   // ЁЯСИ added
            ]);

        $latestCash = Cash::latest()->first();  

          $latestCash->cash -= $request->amount;  

            $latestCash->save(); 

            return response()->json([
                'message'        => 'Amount returned successfully',
                'step'           => $stepText,
                'return_amounts' => $returns
            ]);
        }





        // All Amanot Return 
        public function history()
        {
            $amanotReturned = Amanot::whereNotNull('return_amounts')
                                    ->orderBy('id', 'desc')
                                    ->get();

            return view('backend.amanot.history', compact('amanotReturned'));
        }


        public function show($id)
        {
            $returns = AmanotReturn::with('amanot')->where('amanot_id', $id)->get();
            return response()->json($returns);
        }




    public function amanot_destroy($id)
    {
        $amanot = Amanot::findOrFail($id);
        $amanot->delete();

        return redirect()->route('amanot.index')->with('success', 'Amanot deleted successfully.');
    }



    //Expense

    // public function expense()
    // {

    //     $expenses = Expense::orderBy('id', 'desc')->get();

    //     return view('backend.expense.index', compact('expenses'));


    // }
    
    
    
        public function expense(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to ?? now()->endOfMonth()->toDateString();
        //total commision
        // $chalan_expense = ChalanExpenses::query()
        //     ->when($from && $to, fn($q) => $q->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]))
        //     ->when($from && !$to, fn($q) => $q->whereDate('created_at', '>=', $from))
        //     ->when($to && !$from, fn($q) => $q->whereDate('created_at', '<=', $to))
        //     ->sum('amount');
        // $commission = Helper::sum(Chalan::class, 'commission_amount', 'chalan_date', $from, $to);
        // $charge     = Helper::sum(Charge::class, 'total_charge', 'date', $from, $to);
        // $total_commission = $commission + $charge + $chalan_expense;

        // Display a listing of the resource.
        $expenses = Expense::whereBetween('date', [$from, $to])
            ->latest()
            ->get();



        // dd($from, $to, $chalans->pluck('chalan_date'));
        return view('backend.expense.index', compact('expenses', 'from', 'to'));
    }
    
    
    
    
    

    public function expense_create()
    {

        return view('backend.expense.add');
    }


    public function expense_store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        Expense::create([
            'reason' => $request->reason,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('expense.index')->with('success', 'Expense added successfully.');
    }

    public function expense_destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully.');
    }



    public function dadon_add()
    {

        $dadons = Dadon::with('collections')->orderBy('id', 'desc')->get();

        return view('backend.dadon.index', compact('dadons'));
    }

    public function dadon_store(Request $request)
    {

        // тЬЕ Validate the form inputs
        $request->validate([
            'name' => 'nullable|string|max:255',
            'customer' => 'nullable|string|max:255',
            'total_given_amount' => 'nullable|numeric',
            'due_pay_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        // тЬЕ Store the data
        Dadon::create([
            'name' => $request->name,
            'customer' => $request->customer,
            'total_given_amount' => $request->total_given_amount,
            'given_date' => now()->toDateString(), // auto-fill with today's date
            'due_pay_date' => $request->due_pay_date,
            'note' => $request->note,
        ]);

        // тЬЕ Redirect with success message
        return redirect()->route('dadon_add.index')->with('success', 'Dadon entry created successfully.');

    }

    public function dadon_create()
    {

        return view('backend.dadon.add');
    }
    public function dadon_edit($id)
    {

        $dadon = Dadon::findOrFail($id);
        return view('backend.dadon.edit', compact('dadon'));
    }
    public function dadon_update(Request $request)
    {

    $dadon = Dadon::findOrFail($request->id);

    $dadon->update($request->only(['name', 'customer', 'total_given_amount', 'due_pay_date', 'note']));

    return redirect()->route('dadon_add.index')->with('success', 'ржжрж╛ржжржи рж╕ржлрж▓ржнрж╛ржмрзЗ ржЖржкржбрзЗржЯ рж╣рзЯрзЗржЫрзЗ');

    }

    public function dadon_destroy($id)
    {
        $dadon = Dadon::findOrFail($id);
        $dadon->delete();
        return redirect()->back()->with('success', 'ржжрж╛ржжржи рж╕ржлрж▓ржнрж╛ржмрзЗ ржбрж┐рж▓рж┐ржЯ рж╣ржпрж╝рзЗржЫрзЗ!');
    }

    public function paikar_due(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to ?? now()->endOfMonth()->toDateString();
        //total commision
        // $chalan_expense = ChalanExpenses::query()
        //     ->when($from && $to, fn($q) => $q->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]))
        //     ->when($from && !$to, fn($q) => $q->whereDate('created_at', '>=', $from))
        //     ->when($to && !$from, fn($q) => $q->whereDate('created_at', '<=', $to))
        //     ->sum('amount');
        // $commission = Helper::sum(Chalan::class, 'commission_amount', 'chalan_date', $from, $to);
        // $charge     = Helper::sum(Charge::class, 'total_charge', 'date', $from, $to);
        // $total_commission = $commission + $charge + $chalan_expense;

        // Display a listing of the resource.
        $chalans = Chalan::with(['mohajon'])
            ->whereColumn('total_amount', '>', 'payment_amount')
            ->whereBetween('chalan_date', [$from, $to])
            ->latest()
            ->get();



        // dd($from, $to, $chalans->pluck('chalan_date'));
        return view('backend.paikar_due.list', compact('chalans', 'from', 'to'));
    }

    public function dueSoon()
    {
        $dadons = Dadon::with('collections')
            ->where('status', '0')
            ->orderBy('due_pay_date', 'asc')
            ->get();

        return view('backend.dadon.due_soon', compact('dadons'));
    }


    public function createCollection($id)
    {
        $dadon = Dadon::findOrFail($id);
        return view('backend.dadon.dadon_collection', compact('dadon'));
    }

    public function storeCollection(Request $request)
    {

        $request->validate([
            'dadon_id' => 'required|exists:dadons,id',
            'collection_amount' => 'required|numeric|min:0.01',
            'collection_date' => 'required|date',
            'note' => 'nullable|string|max:500',
        ]);

        // Create a new Collection record using the validated data
        DadonCollection::create([
            'dadon_id' => $request->dadon_id,
            'collection_amount' => $request->collection_amount,
            'collection_date' => $request->collection_date,
            'note' => $request->note,
        ]);

        return redirect()->route('dadon_add.index')->with('success', 'ржЬржорж╛ рж╕ржлрж▓ржнрж╛ржмрзЗ рж░рзЗржХрж░рзНржб ржХрж░рж╛ рж╣ржпрж╝рзЗржЫрзЗ!');
    }

    public function showCollection($id)
    {
        $dadon = Dadon::with(['collections'])->findOrFail($id);

        // dd($dadon->collections);

        $totalCollectedAmount = $dadon->collections->sum('collection_amount');
        $remainingBalance = $dadon->total_given_amount - $totalCollectedAmount;

        return view('backend.dadon.collection_history', compact('dadon', 'totalCollectedAmount', 'remainingBalance'));
    }

    

    //Uttolon

    public function uttolon()
    {

        $uttolons = Uttolon::orderBy('id', 'desc')->get();

        return view('backend.uttolon.index', compact('uttolons'));

    }

    public function uttolon_create()
    {

        return view('backend.uttolon.add');
    }


    public function uttolon_store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Uttolon::create([
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('uttolon.index')->with('success', 'uttolon added successfully.');
    }

    public function uttolon_destroy($id)
    {
        $uttolon = Uttolon::findOrFail($id);
        $uttolon->delete();

        return redirect()->route('uttolon.index')->with('success', 'uttolon deleted successfully.');
    }

}
