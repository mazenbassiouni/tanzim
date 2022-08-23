<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'due_to'];

    public function mission(){
        return $this->belongsTo(Mission::class);
    }
}
