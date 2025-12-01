<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chalan;

class ChalanItem extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chalan_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
    ];
    
    public function chalan()
    {
        return $this->belongsTo(Chalan::class);
    }
}
