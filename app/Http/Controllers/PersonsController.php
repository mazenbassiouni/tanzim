<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Rank;
use App\Models\Unit;
use App\Models\Speciality;
use Illuminate\Support\Facades\Validator;

class PersonsController extends Controller
{
    use Traits\Functions;

    public function index(){
        $persons = Person::all();

        $ranks = Rank::all();
        $units = Unit::all();
        $specialities = Speciality::all();

        return view('tanzim.show-persons')->with([
            'persons' => $persons,
            'ranks' => $ranks,
            'units' => $units,
            'specialities' => $specialities,
        ]);
    }

    public function search(Request $request){
        $q = trim($request->search);

        $ar = explode(' ', $q);

        $result = Person::where(function ($query) use ($ar){
            foreach($ar as $word){
                $query->where('name', 'like', "%$word%");
            }
        })->with('rank')->get();

        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addPerson(Request $request){
        $input = $request->all();

        Validator::extend('isOfficer', function ($attribute, $value, $parameters, $validator) {
            if($validator->getData()['rankId']){
                if($this->isOfficer($validator->getData()['rankId']) && !$value){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }, 'يرجي إدخال رقم الأقدمية');

        $validator = Validator::make($input, [
            'name' => 'required',
            'rankId' => 'required',
            'militaryNum' => 'required|integer',
            'seniorityNum' => 'isOfficer',
            'specialityId' => 'required|integer',
            'service' => 'required|integer',
            'isForce' => 'required|integer',
            'milUnitId' => 'required|integer',
            'unitId' => 'required|integer',
        ],[
            'name.required' => 'يرجي إدخال الإسم',
            'rankId.required' => 'يرجي إدخال الرتبة/درجة',
            'militaryNum.required' => 'يرجي إدخال الرقم العسكري',
            'specialityId.required' => 'يرجي إدخال التخصص',
            'service.required' => 'يرجي تحديد موقف الخدمة',
            'isForce.required' => 'يرجي تحديد موقف القوة',
            'milUnitId.required' => 'يرجي إدخال التسكين',
            'unitId.required' => 'يرجي إدخال التسكين الداخلي',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $person                 = new Person();
        $person->name           = $request->name;
        $person->rank_id        = $request->rankId;
        $person->military_num   = $request->militaryNum;
        $person->seniority_num  = $request->seniorityNum;
        $person->speciality_id  = $request->specialityId;
        $person->service        = $request->service;
        $person->is_force       = $request->isForce;
        $person->mil_unit_id    = $request->milUnitId;
        $person->unit_id        = $request->unitId;
        $person->note           = $request->note ?? '';
        $person->save();

        return back();
    }
}