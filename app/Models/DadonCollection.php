<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadonCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'dadon_id',
        'collection_amount',
        'collection_date',
        'note',
    ];

    public function dadon()
    {
        return $this->belongsTo(Dadon::class);
    }
}
