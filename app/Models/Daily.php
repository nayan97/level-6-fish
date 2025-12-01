<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'mohajon_id',
    //     'customer_id',
    //     'chalan_date',
    //     'product_id',
    //     'quantity',
    //     'amount',
    //     'total_amount',
    // ];
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function mohajon()
    {
        return $this->belongsTo(Mohajon::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
