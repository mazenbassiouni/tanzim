<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'started_at'];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
