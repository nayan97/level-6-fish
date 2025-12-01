<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dadon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer',
        'total_given_amount',
        'given_date',
        'due_pay_date',
        'note',
    ];

    public function collections()
    {
        return $this->hasMany(DadonCollection::class);
    }
}
