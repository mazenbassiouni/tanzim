<?php

namespace App\Http\Controllers\Traits;

trait functions {
    public function isOfficer(int $id){
        if( $id <= 20){
            return true;
        }else{
            return false;
        }
    }
}