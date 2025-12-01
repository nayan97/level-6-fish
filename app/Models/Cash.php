<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash',
        'today_commisoin',
        'pre_day_paikar_due',
        'today_amount',
        'total_amanot',
        'date',
    ];

    public function expenses()
    {
        return $this->hasMany(CashExpense::class);
    }
}
