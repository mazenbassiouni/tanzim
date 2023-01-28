<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Rank;
use App\Models\Unit;
use App\Models\Speciality;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class PersonsController extends Controller
{
    use Traits\Functions;

    public function index(){
        $officers = Person::where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->get();
        $subOfficers = Person::where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->get();
        $soldiers = Person::where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->get();

        $tamam = [
            'total' => Person::whereService(true)->whereIsForce(true)->count(),
            'officers' => $officers->count(),
            'subOfficers' => $subOfficers->count(),
            'soldiers' => $soldiers->count()
        ];

        $ranks = Rank::all();
        $units = Unit::all();
        $specialities = Speciality::all();

        return view('tanzim.show-persons')->with([
            'officers' => $officers,
            'subOfficers' => $subOfficers,
            'soliders' => $soldiers,
            'ranks' => $ranks,
            'units' => $units,
            'specialities' => $specialities,
            'tamam' => $tamam,
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
            // 'service' => 'required|integer',
            'isForce' => 'required|integer',
            'milUnitId' => 'required|integer',
            'unitId' => 'required|integer',
            // 'joinDate' => 'required',
            'layOffDate' => 'required_if:rankId,27',
            'medicalState' => 'required',
            'deletedDate' => 'required_if:isForce,0',

        ],[
            'name.required' => 'يرجي إدخال الإسم',
            'rankId.required' => 'يرجي إدخال الرتبة/درجة',
            'militaryNum.required' => 'يرجي إدخال الرقم العسكري',
            'specialityId.required' => 'يرجي إدخال التخصص',
            'service.required' => 'يرجي تحديد موقف الخدمة',
            'isForce.required' => 'يرجي تحديد موقف القوة',
            'milUnitId.required' => 'يرجي إدخال التسكين',
            'unitId.required' => 'يرجي إدخال التسكين الداخلي',
            'joinDate.required' => 'يرجي إدخال تاريخ الضم',
            'medicalState.required' => 'يرجي إدخال الموقف الطبي',
            'layOffDate.required_if' => 'يرجي إدخال تاريخ التسريح',
            'deletedDate.required_if' => 'يرجي إدخال تاريخ الشطب',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $person                     = new Person();
        $person->name               = $request->name;
        $person->rank_id            = $request->rankId;
        $person->military_num       = $request->militaryNum;
        $person->seniority_num      = $request->seniorityNum;
        $person->speciality_id      = $request->specialityId;
        // $person->service            = $request->service;
        $person->is_force           = $request->isForce;
        $person->join_desc          = $request->joinDesc ?? '';
        $person->mil_unit_id        = $request->milUnitId;
        $person->unit_id            = $request->unitId;
        $person->note               = $request->note ?? '';
        $person->join_date          = $request->joinDate;
        $person->deleted_desc       = $request->deletedDesc ?? '';
        $person->deleted_date       = $request->deletedDate;
        $person->lay_off_date       = $request->layOffDate;
        $person->medical_state      = $request->medicalState;
        $person->medical_cause      = $request->medicalCause;
        $person->save();

        return back();
    }

    public function showPerson(Request $request){
        $person = Person::findOrFail($request->id);

        $ranks = Rank::all();
        $units = Unit::all();
        $specialities = Speciality::all();
        $categories = Category::all();
        
        return view('tanzim.show-person')->with([
            'person' => $person,
            'ranks' => $ranks,
            'units' => $units,
            'specialities' => $specialities,
            'categories' => $categories
        ]);
    }

    public function editPerson(Request $request){
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
            'personId' => 'required|integer',
            'name' => 'required',
            'rankId' => 'required',
            'militaryNum' => 'required|integer',
            'seniorityNum' => 'isOfficer',
            'specialityId' => 'required|integer',
            // 'service' => 'required|integer',
            'isForce' => 'required|integer',
            'milUnitId' => 'required|integer',
            'unitId' => 'required|integer',
            // 'joinDate' => 'required',
            'layOffDate' => 'required_if:rankId,27',
            'medicalState' => 'required',
            'deletedDate' => 'required_if:isForce,0',
        ],[
            'name.required' => 'يرجي إدخال الإسم',
            'rankId.required' => 'يرجي إدخال الرتبة/درجة',
            'militaryNum.required' => 'يرجي إدخال الرقم العسكري',
            'specialityId.required' => 'يرجي إدخال التخصص',
            'service.required' => 'يرجي تحديد موقف الخدمة',
            'isForce.required' => 'يرجي تحديد موقف القوة',
            'milUnitId.required' => 'يرجي إدخال التسكين',
            'unitId.required' => 'يرجي إدخال التسكين الداخلي',
            'joinDate.required' => 'يرجي إدخال تاريخ الضم',
            'medicalState.required' => 'يرجي إدخال الموقف الطبي',
            'layOffDate.required_if' => 'يرجي إدخال تاريخ التسريح',
            'deletedDate.required_if' => 'يرجي إدخال تاريخ الشطب',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $person = Person::findOrFail($request->personId);
        $person->name               = $request->name;
        $person->rank_id            = $request->rankId;
        $person->military_num       = $request->militaryNum;
        $person->seniority_num      = $request->seniorityNum;
        $person->speciality_id      = $request->specialityId;
        // $person->service            = $request->service;
        $person->is_force           = $request->isForce;
        $person->join_desc          = $request->joinDesc ?? '';
        $person->mil_unit_id        = $request->milUnitId;
        $person->unit_id            = $request->unitId;
        $person->note               = $request->note ?? '';
        $person->join_date          = $request->joinDate;
        $person->deleted_desc       = $request->deletedDesc ?? '';
        $person->deleted_date       = $request->deletedDate;
        $person->lay_off_date       = $request->layOffDate;
        $person->medical_state      = $request->medicalState;
        $person->medical_cause      = $request->medicalCause;
        $person->save();

        return back();
    }
}
