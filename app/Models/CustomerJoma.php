<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerJoma extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'jomartaka',
        'jomardate',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
