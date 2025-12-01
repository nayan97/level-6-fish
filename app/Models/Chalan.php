<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChalanItem;
use App\Models\ChalanExpenses;
use App\Models\Customer;
use App\Models\Mohajon;

class Chalan extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'invoice_no',
    //     // 'customer_id',
    //     'mohajon_id',
    //     'chalan_date',
    //     'subtotal',
    //     // 'discount_amount',
    //     // 'discount_percent',
    //     // 'vat_amount',
    //     // 'vat_percent',
    //     'commission_amount',
    //     'commission_percent',
    //     'total_expense',
    //     'total_amount',
    //     'payment_amount',
    //     'note',
    // ];

    protected $guarded = [];
    

    public function chalan_items()
    {
        return $this->hasMany(ChalanItem::class);
    }

    public function chalan_expenses()
    {
        return $this->hasMany(ChalanExpenses::class);
    }

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }
    public function mohajon()
    {
        return $this->belongsTo(Mohajon::class);
    }
}
