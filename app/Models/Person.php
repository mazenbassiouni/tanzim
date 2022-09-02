<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{    
    use HasFactory;

    public function rank(){
        return $this->belongsTo(Rank::class);
    }
}
