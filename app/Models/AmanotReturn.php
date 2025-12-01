<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmanotReturn extends Model
{
    use HasFactory;
     protected $guarded = [];

            public function amanot()
        {
            return $this->belongsTo(Amanot::class, 'amanot_id');
        }


}