<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chalan;
use App\Models\Daily;
use App\Models\Charge;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function chalan()
    // {
    //     return $this->hasMany(Chalan::class);
    // }
    
    public function dailyKroy()
    {
        return $this->hasMany(Daily::class);
    }
    public function charge()
    {
        return $this->hasMany(Charge::class, 'paikar_id');
    }

    public function customerJoma()
    {
        return $this->hasMany(CustomerJoma::class, 'customer_id');
    }

    // total charge
    public function getTotalChargeAttribute()
    {
        return $this->charge()->sum('total_charge');
    }

    // মোট ক্রয়
    public function getTotalDailyKroyAttribute()
    {
        return $this->dailyKroy()->sum('total_amount') + $this->total_charge + $this->jer;
    }
    // payment amount
    public function getPaymentAmountAttribute()
    {
        return $this->dailyKroy()->sum('payment_amount');
    }

    // মোট জমা
    public function getTotalJomaAttribute()
    {
        return $this->customerJoma()->sum('jomartaka') + $this->payment_amount;
    }

    // বাকী
    public function getBalanceAttribute()
    {
        return $this->total_joma - $this->total_daily_kroy;
    }

}
