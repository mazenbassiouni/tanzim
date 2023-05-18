<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Speciality;

class SpecialitiesController extends Controller
{
    public function addSpeciality(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ],[
            'name.required' => 'يرجى إدخال التخصص',
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'add speciality']);
        }

        $speciality = new Speciality();
        $speciality->name = $request->name;
        $speciality->save();

        return back();
    }

    public function editSpeciality(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'specialityId' => 'required'
        ],[
            'name.required' => 'يرجى إدخال التخصص',
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit speciality']);
        }
        
        $speciality = Speciality::findOrFail($request->specialityId);
        $speciality->name = $request->name;
        $speciality->save();

        return back();
    }

    public function deletespeciality(Request $request){
        $speciality = Speciality::findOrFail($request->specialityId);
        $speciality->delete();

        return back();
    }
}
