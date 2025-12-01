<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChalanBakiReturn extends Model
{
    use HasFactory;
     protected $guarded = [];


    public function chalan()
        {
            return $this->belongsTo(Chalan::class, 'chalan_id');
        }
}
