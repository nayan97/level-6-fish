<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'paikar_id',
        'total_qty',
        'charge_per_kg',
        'total_charge',
        'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'paikar_id');
    }
}
