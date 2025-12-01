<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chalan;

class Mohajon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function chalan()
    {
        return $this->hasMany(Chalan::class);
    }
}
