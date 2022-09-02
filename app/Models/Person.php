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

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function speciality(){
        return $this->belongsTo(speciality::class);
    }

    public function milUnit(){
        return $this->belongsTo(Unit::class, 'mil_unit_id');
    }

    public function missions(){
        return $this->hasMany(Mission::class);
    }
}
