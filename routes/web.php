<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\ChalanController;
use App\Http\Controllers\CashAddController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\MohajonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return redirect()->to('login');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth']);



Route::middleware(['auth'])->group(function () {
    //admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    //dadon
    Route::get('/dashboard/dadon_due', [ContentController::class, 'dadon_due'])->name('dadon_due.index');


    Route::get('/dashboard/dadon_add', [ContentController::class, 'dadon_add'])->name('dadon_add.index');
    Route::get('/dashboard/dadon_create', [ContentController::class, 'dadon_create'])->name('dadon.create');
    Route::post('/dashboard/dadon_store', [ContentController::class, 'dadon_store'])->name('dadon.store');
    Route::get('/dashboard/dadon_edit/{id}', [ContentController::class, 'dadon_edit'])->name('dadon.edit');
    Route::put('/dashboard/dadon/update', [ContentController::class, 'dadon_update'])->name('dadon.update');
    Route::delete('/dashboard/dadon_destroy/{id}', [ContentController::class, 'dadon_destroy'])->name('dadon.destroy');
    Route::get('/dadon/due-soon', [ContentController::class, 'dueSoon'])->name('dadon.due_soon');

    // dadon collection
    Route::get('/dashboard/collection/create/{id}', [ContentController::class, 'createCollection'])->name('collections.create');
    Route::post('/dashboard/collection/store', [ContentController::class, 'storeCollection'])->name('collections.store');
    Route::get('/dashboard/collection/show/{id}', [ContentController::class, 'showCollection'])->name('collections.show');



    //amanot
    Route::get('/dashboard/amanot', [ContentController::class, 'amanot'])->name('amanot.index');
    Route::get('/dashboard/amanot_create', [ContentController::class, 'amanot_create'])->name('amanot.create');
    Route::post('/dashboard/amanot_store', [ContentController::class, 'amanot_store'])->name('amanot.store');

    Route::post('/dashboard/amanot/{id}/return', [ContentController::class, 'returnAmount'])->name('amanot.return');
    Route::get('/amanot/history', [ContentController::class, 'history'])->name('amanot.history');
   Route::get('/amanot-return/show/{amanot_id}', [ContentController::class, 'show']);



    // Route::get('/dashboard/amanot_edit/{id}', [ContentController::class, 'amanot_edit'])->name('amanot.edit');
    Route::get('/dashboard/amanot_destroy/{id}', [ContentController::class, 'amanot_destroy'])->name('amanot.destroy');
    
    //income
    Route::get('/dashboard/income', [ContentController::class, 'income'])->name('income.index');
    Route::get('/dashboard/income_create', [ContentController::class, 'income_create'])->name('income.create');
    Route::post('/dashboard/income_store', [ContentController::class, 'income_store'])->name('income.store');
    // Route::get('/dashboard/income_edit/{id}', [ContentController::class, 'income_edit'])->name('income.edit');
    Route::get('/dashboard/income_destroy/{id}', [ContentController::class, 'income_destroy'])->name('income.destroy');

    // expense
    Route::get('/dashboard/expense', [ContentController::class, 'expense'])->name('expense.index');
    Route::get('/dashboard/expense_create', [ContentController::class, 'expense_create'])->name('expense.create');
    Route::post('/dashboard/expense_store', [ContentController::class, 'expense_store'])->name('expense.store');
    Route::get('/dashboard/expense_edit/{id}', [ContentController::class, 'expense_edit'])->name('expense.edit');
    Route::get('/dashboard/expense_destroy/{id}', [ContentController::class, 'expense_destroy'])->name('expense.destroy');

    //uttolon
    Route::get('/dashboard/uttolon', [ContentController::class, 'uttolon'])->name('uttolon.index');
    Route::get('/dashboard/uttolon_create', [ContentController::class, 'uttolon_create'])->name('uttolon.create');
    Route::post('/dashboard/uttolon_store', [ContentController::class, 'uttolon_store'])->name('uttolon.store');
    Route::get('/dashboard/uttolon_destroy/{id}', [ContentController::class, 'uttolon_destroy'])->name('uttolon.destroy');
    
    //cash add
    Route::get('/dashboard/cashadd', [CashAddController::class, 'index'])->name('cashadd.index');
    Route::get('/dashboard/cashadd_create', [CashAddController::class, 'create'])->name('cashadd.create');
    Route::post('/dashboard/cashadd_store', [CashAddController::class, 'store'])->name('cashadd.store');
    Route::get('/dashboard/cashadd_destroy/{id}', [CashAddController::class, 'destroy'])->name('cashadd.destroy');

    //cash
    Route::get('/dashboard/cash', [CashController::class, 'index'])->name('cash.index');
    Route::get('/dashboard/cash/create', [CashController::class, 'create'])->name('cash.create');
    Route::post('/dashboard/cash/store', [CashController::class, 'store'])->name('cash.store');
    Route::get('/dashboard/cash/destroy/{id}', [CashController::class, 'destroy'])->name('cash.destroy');
    Route::get('/dashboard/cash/show/{id}', [CashController::class, 'show'])->name('cash.show');


    //paikar_due
    Route::get('/dashboard/paikar_due', [ContentController::class, 'paikar_due'])->name('paikar_due.index');


    // customer route
    Route::get('/dashboard/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/dashboard/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/dashboard/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/dashboard/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('/dashboard/customers/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/dashboard/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/store-ajax', [CustomerController::class, 'storeAjax'])->name('customers.store_ajax');

    Route::get('/customer/balance/{id}', [CustomerController::class, 'getCustomerBalance']);


    Route::get('/dashboard/customers/jomalist', [CustomerController::class, 'jomaList'])->name('customers_joma.index');
    Route::get('/dashboard/customers/joma/create', [CustomerController::class, 'jomaCreate'])->name('customers_joma.create');
    Route::post('/dashboard/customers/joma/store', [CustomerController::class, 'jomastore'])->name('customers_joma.store');
    Route::delete('/dashboard/customers/joma/destroy/{id}', [CustomerController::class, 'jomaDestroy'])->name('customers_joma.destroy');

    // mohajon route
    Route::get('/dashboard/mohajons', [MohajonController::class, 'index'])->name('mohajons.index');
    Route::get('/dashboard/mohajons/create', [MohajonController::class, 'create'])->name('mohajons.create');
    Route::post('/dashboard/mohajons/store', [MohajonController::class, 'store'])->name('mohajons.store');
    Route::get('/dashboard/mohajons/edit/{id}', [MohajonController::class, 'edit'])->name('mohajons.edit');
    Route::post('/dashboard/mohajons/update', [MohajonController::class, 'update'])->name('mohajons.update');
    Route::delete('/dashboard/mohajons/destroy/{id}', [MohajonController::class, 'destroy'])->name('mohajons.destroy');
    Route::post('/customers/store-ajax', [MohajonController::class, 'storeAjax'])->name('mohajons.store_ajax');



    // chalan route

    Route::get('/dashboard/chalans', [ChalanController::class, 'index'])->name('chalans.index');
    Route::get('/dashboard/chalans/create', [ChalanController::class, 'create'])->name('chalans.create');
    Route::post('/dashboard/chalans/store', [ChalanController::class, 'store'])->name('chalans.store');
    Route::get('/dashboard/chalans/show/{id}', [ChalanController::class, 'show'])->name('chalans.show');
    Route::get('/dashboard/chalans/edit/{id}', [ChalanController::class, 'edit'])->name('chalans.edit');
    Route::put('/dashboard/chalans/update', [ChalanController::class, 'update'])->name('chalans.update');
    Route::delete('/dashboard/chalans/destroy/{id}', [ChalanController::class, 'destroy'])->name('chalans.destroy');
    Route::get('/dashboard/year/{year}', [DashboardController::class, 'filterByYear'])->name('dashboard.year');
    Route::get('/dashboard/chalans/create/{mohajon_id}/{date}', [ChalanController::class, 'createbymohajon'])->name('chalansbymohajon.create');
    Route::post('/dashboard/chalans/chalanstore', [ChalanController::class, 'chalanStore'])->name('chalans.chalanStore');

    Route::get('/chalans/history', [ChalanController::class, 'history'])->name('chalans.history');
    Route::get('/chalans-return/show/{chalan_id}', [ChalanController::class, 'chalanBakiShow']);



    
    // product
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


    // chalan report

    Route::get('/chalan-report', [ChalanController::class, 'report'])->name('chalan.report');
    Route::post('/dashboard/chalanbaki/{id}/return', [ChalanController::class, 'bakiReturn'])->name('chalanbaki.return');

    //Daily Buy Sazzad
    Route::get('/dashboard/daily/index', [DailyController::class, 'index'])->name('daily.index');
    Route::get('/dashboard/daily/create', [DailyController::class, 'create'])->name('daily.create');
    Route::post('/dashboard/daily/store', [DailyController::class, 'store'])->name('daily.store');
    Route::get('/dashboard/kroyhishab', [DailyController::class, 'kroyhishab'])->name('kroy.hishab');
    Route::delete('/dashboard/daily/destroy/{id}', [DailyController::class, 'destroy'])->name('daily.destroy');
    // daily kroy destroy based on date and mohajon
    Route::delete('/dashboard/daily/destroy/{mohajon_id}/{date}', [DailyController::class, 'destroyByDate'])->name('daily.destroy_by_date');


    Route::post('/charge/calculate', [DailyController::class, 'chargeCalculate'])->name('charge.store');
    Route::post('/get-paikar-charge-sum', [DailyController::class, 'getPaikarChargeSum']);
    Route::get('/paikar-charge', [DailyController::class, 'PaikarChargeList'])->name('paikar_charge.index');

});
