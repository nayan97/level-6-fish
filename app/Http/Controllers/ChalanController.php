<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Daily;
use App\Models\Chalan;
use App\Models\Mohajon;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ChalanItem;
use Illuminate\Http\Request;
use App\Models\ChalanExpenses;
use App\Models\ChalanBakiReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChalanController extends Controller
{
    public function index()
    {
        // Display a listing of the resource.
        // $chalans = Chalan::with(['customer','mohajon'])->latest()->get();
        $chalans = Chalan::with(['mohajon'])->latest()->get();
        return view('backend.chalan.index', compact('chalans'));
    }

    public function create()
    {
        // $customers = Customer::all();
        $mohajons = Mohajon::all();
        $products = Product::all();
        $lastChalan = Chalan::latest()->first();
        $nextInvoiceNumber = $lastChalan ? (int) str_replace('INV-', '', $lastChalan->invoice_no) + 1 : 1202500123;
        $invoice_no = 'INV-' . str_pad($nextInvoiceNumber, 7, '0', STR_PAD_LEFT);

        return view('backend.chalan.create', compact('mohajons','products', 'invoice_no'));
    }


    public function store(Request $request,)
    {
        

        // Validate the incoming request data
        try {
            $validatedData = $request->validate([
                // Customer Validation
                // 'customer_id' => 'required|exists:customers,id',
                'mohajon_id' => 'required|exists:mohajons,id',

                // Chalan Header Validation
                'invoice_no' => 'required|string|unique:chalans,invoice_no|max:255',
                'chalan_date' => 'required|date',

                // Product Items Validation
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',

                // Expense Items Validation
                'expenses' => 'nullable|array', // Optional array of expenses
                'expenses.*.expense_type' => 'required_with:expenses|string|max:255',
                'expenses.*.amount' => 'required_with:expenses|numeric|min:0',

                // Overall Calculation Fields (from hidden inputs)
                // 'overall_discount_amount' => 'nullable|numeric|min:0',
                // 'overall_discount_percent' => 'nullable|numeric|min:0|max:100',
                // 'overall_vat_amount' => 'nullable|numeric|min:0',
                // 'overall_vat_percent' => 'nullable|numeric|min:0|max:100',
                'commission_amount' => 'nullable|numeric|min:0',
                'commission_percent' => 'nullable|numeric|min:0|max:100',
                'payment_amount' => 'nullable|numeric|min:0',
                'total_expenses_amount' => 'nullable|numeric',
                'sub_total' => 'nullable|numeric',
                'grand_total' => 'nullable|numeric',
            ]);

            // dd($request->all());


            // Start a database transaction for atomicity
            DB::beginTransaction();

            // $customerId = $validatedData['customer_id'] ?? null;
            $mohajonId = $validatedData['mohajon_id'] ?? null;

            $chalanItemsData = [];

            foreach ($validatedData['items'] as $item) {
                $itemQuantity = (float) $item['quantity'];
                $itemUnitPrice = (float) $item['unit_price'];
                $finalItemTotal = $itemQuantity * $itemUnitPrice;

                $productName = $item['item_name'];

                $chalanItemsData[] = [
                    'item_name' => $productName,
                    'quantity' => $itemQuantity,
                    'unit_price' => $itemUnitPrice,
                    'total_price' => $finalItemTotal,
                ];
            }

            $chalanExpensesData = [];
            if (isset($validatedData['expenses']) && is_array($validatedData['expenses'])) {
                foreach ($validatedData['expenses'] as $expense) {
                    $expenseAmount = (float) $expense['amount'];
                    $chalanExpensesData[] = [
                        'expense_type' => $expense['expense_type'],
                        'amount' => $expenseAmount,
                    ];
                }
            }

            $chalan = Chalan::create([
                // 'customer_id' => $customerId,
                'mohajon_id' => $mohajonId,
                'invoice_no' => $validatedData['invoice_no'],
                'chalan_date' => $validatedData['chalan_date'],
                'subtotal' => $validatedData['sub_total'],
                // 'discount_amount' => $validatedData['overall_discount_amount'] ?? 0,
                // 'discount_percent' => $validatedData['overall_discount_percent'] ?? 0,
                // 'vat_amount' => $validatedData['overall_vat_amount'] ?? 0,
                // 'vat_percent' => $validatedData['overall_vat_percent'] ?? 0,
                'commission_amount' => $validatedData['commission_amount'] ?? 0,
                'commission_percent' => $validatedData['commission_percent'] ?? 0,
                'total_expense' => $validatedData['total_expenses_amount'] ?? 0,
                'total_amount' => $validatedData['grand_total'] ?? 0,
                'payment_amount' => $validatedData['payment_amount'] ?? 0,
            ]);

            $chalan->chalan_items()->createMany($chalanItemsData);
            if (!empty($chalanExpensesData)) {
                $chalan->chalan_expenses()->createMany($chalanExpensesData);
            }

                $today = Carbon::now('Asia/Dhaka')->toDateString();

                // Get today cash row
                $todayCash = Cash::where('date', $today)->first();

                // Get previous day closing cash
                $previousCashRow = Cash::where('date', '<', $today)
                                        ->orderBy('date', 'desc')
                                        ->first();

                $previousCash = $previousCashRow ? $previousCashRow->cash : 0;

                // Net change for this action
                $netAmount = $validatedData['grand_total'] - $validatedData['payment_amount'];

                if ($todayCash) {

                    // 👉 UPDATE same day row
                    $todayCash->today_amount += $validatedData['grand_total'];
                    $todayCash->cash = $previousCash + $todayCash->today_amount;

                    $todayCash->save();

                } else {

                    // 👉 CREATE new day row
                    Cash::create([
                        'date'         => $today,
                        'today_amount' => $validatedData['grand_total'],
                        'cash'         => $previousCash + $validatedData['grand_total'],
                    ]);
                }



            DB::commit();

            return redirect()->route('chalans.index')->with('success', 'চালান সফলভাবে তৈরি হয়েছে!');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error creating chalan: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'চালান তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage())->withInput();
        }
    }

        public function chalanStore(Request $request,)
    {
        

        // Validate the incoming request data
        try {
            $validatedData = $request->validate([
                // Customer Validation
                // 'customer_id' => 'required|exists:customers,id',
                'mohajon_id' => 'required|exists:mohajons,id',

                // Chalan Header Validation
                'invoice_no' => 'required|string|unique:chalans,invoice_no|max:255',
                'chalan_date' => 'required|date',

                // Product Items Validation
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',

                // Expense Items Validation
                'expenses' => 'nullable|array', // Optional array of expenses
                'expenses.*.expense_type' => 'required_with:expenses|string|max:255',
                'expenses.*.amount' => 'required_with:expenses|numeric|min:0',

                // Overall Calculation Fields (from hidden inputs)
                // 'overall_discount_amount' => 'nullable|numeric|min:0',
                // 'overall_discount_percent' => 'nullable|numeric|min:0|max:100',
                // 'overall_vat_amount' => 'nullable|numeric|min:0',
                // 'overall_vat_percent' => 'nullable|numeric|min:0|max:100',
                'commission_amount' => 'nullable|numeric|min:0',
                'commission_percent' => 'nullable|numeric|min:0|max:100',
                'payment_amount' => 'nullable|numeric|min:0',
                'total_expenses_amount' => 'nullable|numeric',
                'sub_total' => 'nullable|numeric',
                'grand_total' => 'nullable|numeric',
            ]);

            // dd($request->all());




            // Start a database transaction for atomicity
            DB::beginTransaction();

            // $customerId = $validatedData['customer_id'] ?? null;
            $mohajonId = $validatedData['mohajon_id'] ?? null;

            $chalanItemsData = [];

            foreach ($validatedData['items'] as $item) {
                $itemQuantity = (float) $item['quantity'];
                $itemUnitPrice = (float) $item['unit_price'];
                $finalItemTotal = $itemQuantity * $itemUnitPrice;

                $productName = $item['item_name'];

                $chalanItemsData[] = [
                    'item_name' => $productName,
                    'quantity' => $itemQuantity,
                    'unit_price' => $itemUnitPrice,
                    'total_price' => $finalItemTotal,
                ];
            }

            $chalanExpensesData = [];
            if (isset($validatedData['expenses']) && is_array($validatedData['expenses'])) {
                foreach ($validatedData['expenses'] as $expense) {
                    $expenseAmount = (float) $expense['amount'];
                    $chalanExpensesData[] = [
                        'expense_type' => $expense['expense_type'],
                        'amount' => $expenseAmount,
                    ];
                }
            }

            $chalan = Chalan::create([
                // 'customer_id' => $customerId,
                'mohajon_id' => $mohajonId,
                'invoice_no' => $validatedData['invoice_no'],
                'chalan_date' => $validatedData['chalan_date'],
                'subtotal' => $validatedData['sub_total'],
                // 'discount_amount' => $validatedData['overall_discount_amount'] ?? 0,
                // 'discount_percent' => $validatedData['overall_discount_percent'] ?? 0,
                // 'vat_amount' => $validatedData['overall_vat_amount'] ?? 0,
                // 'vat_percent' => $validatedData['overall_vat_percent'] ?? 0,
                'commission_amount' => $validatedData['commission_amount'] ?? 0,
                'commission_percent' => $validatedData['commission_percent'] ?? 0,
                'total_expense' => $validatedData['total_expenses_amount'] ?? 0,
                'total_amount' => $validatedData['grand_total'] ?? 0,
                'payment_amount' => $validatedData['payment_amount'] ?? 0,
            ]);

            $chalan->chalan_items()->createMany($chalanItemsData);
            if (!empty($chalanExpensesData)) {
                $chalan->chalan_expenses()->createMany($chalanExpensesData);
            }

            // Get date-time from URL
               // Get values from hidden fields
                $urlMohajonId = $request->url_mohajon_id;
                $urlDateTime  = $request->url_datetime;

                // dd($urlMohajonId);
                // dd($urlDateTime);

                // Update Daily status
                if ($urlMohajonId && $urlDateTime) {
                    \App\Models\Daily::where('mohajon_id', $urlMohajonId)
                        ->where('created_at', $urlDateTime)
                        // ->where('status', 0)
                        ->update(['status' => 1]);
                }


 
                $today = Carbon::now('Asia/Dhaka')->toDateString();

                // Get today cash row
                $todayCash = Cash::where('date', $today)->first();

                // Get previous day closing cash
                $previousCashRow = Cash::where('date', '<', $today)
                                        ->orderBy('date', 'desc')
                                        ->first();

                $previousCash = $previousCashRow ? $previousCashRow->cash : 0;

                // Net change for this action
                $netAmount = $validatedData['grand_total'] - $validatedData['payment_amount'];

                if ($todayCash) {

                    // 👉 UPDATE same day row
                    $todayCash->today_amount += $validatedData['grand_total'];
                    $todayCash->cash = $previousCash + $todayCash->today_amount;

                    $todayCash->save();

                } else {

                    // 👉 CREATE new day row
                    Cash::create([
                        'date'         => $today,
                        'today_amount' => $validatedData['grand_total'],
                        'cash'         => $previousCash + $validatedData['grand_total'],
                    ]);
                }



            DB::commit();

            return redirect()->route('chalans.index')->with('success', 'চালান সফলভাবে তৈরি হয়েছে!');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error creating chalan: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'চালান তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage())->withInput();
        }
    }

        // chanlan baki return 

  public function bakiReturn(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'note'   => 'nullable|string',
    ]);

    $amanot = Chalan::findOrFail($id);

    if ($request->amount > $amanot->total_amount) {
        return response()->json([
            'message' => 'Return amount cannot be greater than stored amount'
        ], 422);
    }

    // Update payment amount
    $amanot->payment_amount += $request->amount;

    // Decode JSON to array
    $returns = json_decode($amanot->return_amounts, true);

    if (!is_array($returns)) {
        $returns = [];
    }

    $returns[] = (float) $request->amount;
    $amanot->return_amounts = json_encode($returns);
    $amanot->save();


    /* -----------------------------------------
     | GENERATE NEXT STEP (Installment Number)
     | -----------------------------------------
     */
    // Count existing returns for this chalan
    $count = ChalanBakiReturn::where('chalan_id', $amanot->id)->count();

    // Next installment number
    $nextNumber = $count + 1;

    // Convert number ---> 1st, 2nd, 3rd, 4th...
    $suffix = 'th';
    if ($nextNumber % 10 == 1 && $nextNumber != 11) $suffix = 'st';
    if ($nextNumber % 10 == 2 && $nextNumber != 12) $suffix = 'nd';
    if ($nextNumber % 10 == 3 && $nextNumber != 13) $suffix = 'rd';

    $stepText = $nextNumber . $suffix . ' Installment';


    /* -----------------------------------------
     | SAVE HISTORY
     | -----------------------------------------
     */
    ChalanBakiReturn::create([
        'chalan_id' => $amanot->id,
        'amount'    => $request->amount,
        'note'      => $request->note,
        'date'      => now(),
        'step'      => $stepText,  // 👈 NEW FIELD
    ]);

                $today = Carbon::now('Asia/Dhaka')->toDateString();

                // Get today cash row
                $todayCash = Cash::where('date', $today)->first();

                // Get previous day closing cash
                $previousCashRow = Cash::where('date', '<', $today)
                                        ->orderBy('date', 'desc')
                                        ->first();

                $previousCash = $previousCashRow ? $previousCashRow->cash : 0;

                // Net change for this action
                $netAmount = $validatedData['grand_total'] - $validatedData['payment_amount'];

                if ($todayCash) {

                    // 👉 UPDATE same day row
                    $todayCash->today_amount += $validatedData['grand_total'];
                    $todayCash->cash = $previousCash + $todayCash->today_amount;

                    $todayCash->save();

                } else {

                    // 👉 CREATE new day row
                    Cash::create([
                        'date'         => $today,
                        'today_amount' => $validatedData['grand_total'],
                        'cash'         => $previousCash + $validatedData['grand_total'],
                    ]);
                }
    return response()->json([
        'message' => 'Amount returned successfully',
        'step'    => $stepText,
        'return_amounts' => $returns
    ]);
}

public function history()
{
$amanotReturned = Chalan::whereNotNull('return_amounts')
    ->with('mohajon')
    ->orderBy('id', 'desc')
    ->get();
    
    return view('backend.chalan.history', compact('amanotReturned'));
}

    public function createbymohajon($mohajon_id, $date)
    {
        $daily = Daily::with(['mohajon','product'])
            ->where('mohajon_id', $mohajon_id)
            ->where('created_at', $date)
            ->get();

        $header = [
            'mohajon_id' => $daily->first()->mohajon->id ?? '',
            'mohajon_name' => $daily->first()->mohajon->name ?? '',
            'created_at'  => $daily->first()->created_at ?? '',
        ];

        // product loop map
        $chalanItems = $daily->map(function ($item) {
            return [
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'quantity'     => $item->quantity,
                'amount'       => $item->amount,
                'total_amount' => $item->total_amount,
            ];
        });

        $products = Product::all();
        $lastChalan = Chalan::latest()->first();
        $nextInvoiceNumber = $lastChalan ? (int) str_replace('INV-', '', $lastChalan->invoice_no) + 1 : 1202500123;
        $invoice_no = 'INV-' . str_pad($nextInvoiceNumber, 7, '0', STR_PAD_LEFT);

        return view('backend.chalan.createbymohajon', compact('header','products','chalanItems', 'invoice_no'));
    }




            public function chalanBakiShow($id)
        {
            $returns = ChalanBakiReturn::with('chalan')->where('chalan_id', $id)->get();
            return response()->json($returns);
        }


    public function show($id)
    {
        $chalan = Chalan::with(['chalan_items', 'chalan_expenses'])->findOrFail($id);
        return view('backend.chalan.show', compact('chalan'));
    }

    

    public function edit($id)
    {
        // $customers = Customer::all();
        $products = Product::all();
        $mohajons = Mohajon::all();
        $chalan = Chalan::with(['chalan_items', 'chalan_expenses'])->findOrFail($id);
        return view('backend.chalan.edit', compact('chalan','products','mohajons'));
    }

    public function update(Request $request)
    {

        $chalan = Chalan::findOrFail($request->id);

        $validatedData = $request->validate([
            // 'customer_id' => 'required|exists:customers,id',
            'mohajon_id' => 'required|exists:mohajons,id',
            'chalan_date' => 'required|date',

            // Items validation: add 'id' as nullable for existing items
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:chalan_items,id', // Validate item ID if present
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',

            // Expenses validation: add 'id' as nullable for existing expenses
            'expenses' => 'array',
            'expenses.*.id' => 'nullable|exists:chalan_expenses,id', // Validate expense ID if present
            'expenses.*.expense_type' => 'nullable|string|max:255',
            'expenses.*.amount' => 'nullable|numeric|min:0',

            // 'overall_discount_amount' => 'nullable|numeric|min:0',
            // 'overall_discount_percent' => 'nullable|numeric|min:0|max:100',
            // 'overall_vat_amount' => 'nullable|numeric|min:0',
            // 'overall_vat_percent' => 'nullable|numeric|min:0|max:100',
            'commission_amount' => 'nullable|numeric|min:0',
            'commission_percent' => 'nullable|numeric|min:0|max:100',
            'payment_amount' => 'nullable|numeric|min:0',
            'total_expenses_amount' => 'nullable|numeric',
            'sub_total' => 'nullable|numeric',
            'grand_total' => 'nullable|numeric',
        ]);

        // dd($request->all());

        // Use a database transaction to ensure atomicity
        DB::transaction(function () use ($request, $chalan, $validatedData) {


            // --- Sync Chalan Items ---
            $submittedItemIds = [];
            if (isset($validatedData['items']) && is_array($validatedData['items'])) {
                foreach ($validatedData['items'] as $itemData) {

                    $itemQuantity = (float) $itemData['quantity'];
                    $itemUnitPrice = (float) $itemData['unit_price'];
                    $finalItemTotal = $itemQuantity * $itemUnitPrice;

                    $productName = $itemData['item_name'];

                    if (isset($itemData['id'])) {
                        // Existing item: update it
                        $item = ChalanItem::find($itemData['id']);
                        if ($item && $item->chalan_id === $chalan->id) { // Security check
                            $item->update([
                                'item_name' => $productName,
                                'quantity' => $itemQuantity,
                                'unit_price' => $itemUnitPrice,
                                'total_price' => $finalItemTotal,
                            ]);
                            $submittedItemIds[] = $item->id;
                        }
                    } else {
                        // New item: create it
                        $newItem = $chalan->chalan_items()->create([
                            'item_name' => $itemData['item_name'],
                            'quantity' => $itemData['quantity'],
                            'unit_price' => $itemData['unit_price'],
                            'total_price' => (float) ($itemData['quantity'] * $itemData['unit_price']),
                        ]);
                        $submittedItemIds[] = $newItem->id;
                    }
                }
            }


            // --- Sync Chalan Expenses ---
            $submittedExpenseIds = [];
            if (isset($validatedData['expenses']) && is_array($validatedData['expenses'])) {
                foreach ($validatedData['expenses'] as $expenseData) {

                    $expenseAmount = (float) $expenseData['amount'];

                    if (isset($expenseData['id'])) {
                        // Existing expense: update it
                        $expense = ChalanExpense::find($expenseData['id']);
                        if ($expense && $expense->chalan_id === $chalan->id) { // Security check
                            $expense->update([
                                'expense_type' => $expenseData['expense_type'],
                                'amount' => $expenseAmount,
                            ]);
                            $submittedExpenseIds[] = $expense->id;
                        }
                    } else {
                        // New expense: create it
                        $newExpense = $chalan->chalan_expenses()->create([
                            'expense_type' => $expenseData['expense_type'],
                            'amount' => $expenseData['amount'],
                        ]);
                        $submittedExpenseIds[] = $newExpense->id;
                    }
                }
            }

            // Update the main Chalan details
            $chalan->update([
                // 'customer_id' => $validatedData['customer_id'],
                'mohajon_id' => $validatedData['mohajon_id'],
                'chalan_date' => $validatedData['chalan_date'],
                // 'discount_amount' => $validatedData['overall_discount_amount'] ?? 0,
                // 'discount_percent' => $validatedData['overall_discount_percent'] ?? 0,
                // 'vat_amount' => $validatedData['overall_vat_amount'] ?? 0,
                // 'vat_percent' => $validatedData['overall_vat_percent'] ?? 0,
                'commission_amount' => $validatedData['commission_amount'] ?? 0,
                'commission_percent' => $validatedData['commission_percent'] ?? 0,
                'total_expense' => $validatedData['total_expenses_amount'] ?? 0,
                'subtotal' => $validatedData['sub_total'] ?? 0,
                'total_amount' => $validatedData['grand_total'] ?? 0,
                'payment_amount' => $validatedData['payment_amount'] ?? 0,
            ]);

            // Delete items that were not in the submitted data
            $chalan->chalan_items()->whereNotIn('id', $submittedItemIds)->delete();

            // Delete expenses that were not in the submitted data
            $chalan->chalan_expenses()->whereNotIn('id', $submittedExpenseIds)->delete();
        });

        return redirect()->route('chalans.index')->with('success', 'চালান সফলভাবে আপডেট করা হয়েছে!');
    }

    public function report(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to ?? now()->endOfMonth()->toDateString();

        $chalans = Chalan::with(['mohajon', 'chalan_items'])
            ->whereBetween('chalan_date', [$from, $to])
            ->orderBy('chalan_date', 'desc')
            ->get();
        // $chalans = Chalan::with(['customer','mohajon', 'chalan_items'])
        //     ->whereBetween('chalan_date', [$from, $to])
        //     ->orderBy('chalan_date', 'desc')
        //     ->get();
        return view('backend.reports.report', compact('chalans', 'from', 'to'));
    }


    public function destroy($id)
    {
        $chalan = Chalan::findOrFail($id);
        $chalan->delete();
        return redirect()->route('chalans.index')->with('success', 'চালান সফলভাবে ডিলিট হয়েছে!');
    }

}
