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
        $officers = Person::where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->with(['rank', 'speciality', 'unit', 'milUnit'])->get();
        $subOfficers = Person::where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->with(['rank', 'speciality', 'unit', 'milUnit'])->get();
        $soldiers = Person::where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->with(['rank', 'speciality', 'unit', 'milUnit'])->get();
        $notForce = Person::whereIsForce(false)->orderBy('deleted_date','DESC')->with(['rank', 'speciality', 'unit', 'milUnit'])->get();

        $tamam = [
            'all' =>[
                'officers' => $officers->count(),
                'subOfficers' => $subOfficers->count(),
                'soldiers' => $soldiers->count()
            ],
            'fmc' => [
                'officers' => Person::whereIn('unit_id', [2,3,4,5,6])->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::whereIn('unit_id', [2,3,4,5,6])->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::whereIn('unit_id', [2,3,4,5,6])->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            'ramadan' => [
                'officers' => Person::whereIn('unit_id', [16,17,18,19,20,21,22])->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::whereIn('unit_id', [16,17,18,19,20,21,22])->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::whereIn('unit_id', [16,17,18,19,20,21,22])->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            '205' => [
                'officers' => Person::whereIn('unit_id', [7,8,9,10,11,12,13,14])->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::whereIn('unit_id', [7,8,9,10,11,12,13,14])->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::whereIn('unit_id', [7,8,9,10,11,12,13,14])->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            '24' => [
                'officers' => Person::whereIn('unit_id', [15])->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::whereIn('unit_id', [15])->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::whereIn('unit_id', [15])->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            'ka3da' => [
                'officers' => Person::where('unit_id', 27)->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::where('unit_id', 27)->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::where('unit_id', 27)->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            'keyada' => [
                'officers' => Person::where('unit_id', 1)->where('rank_id','<=', 21)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'subOfficers' => Person::where('unit_id', 1)->where('rank_id','>', 21)->where('rank_id','<>', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count(),
                'soldiers' => Person::where('unit_id', 1)->where('rank_id','=', 27)->orderBy('rank_id')->whereService(true)->whereIsForce(true)->count()
            ],
            
        ];

        $ranks = Rank::all();
        $units = Unit::all();
        $specialities = Speciality::orderBy('name')->get();

        $ousideAttachedPeople = Person::where('is_force', 1)->whereHas('missions', function ($query){
            $query->where('category_id', 21)->whereHas('tasks', function ($query){
                $query->where('status', '<>', 'done');
            });
        })->orderBy('rank_id')->with([
            'rank',
            'missions' => function ($query){
                $query->where('category_id', 21)
                    ->whereHas('tasks', function ($query){
                        $query->where('status', '<>', 'done');
                    });
            }
        ])->get();

        $insideAttachedPeople = Person::whereHas('missions', function ($query){
            $query->where('category_id', 20)->whereHas('tasks', function ($query){
                $query->where('status', '<>', 'done');
            });
        })->orderBy('rank_id')->with([
            'rank',
            'missions' => function ($query){
                $query->where('category_id', 20)
                    ->whereHas('tasks', function ($query){
                        $query->where('status', '<>', 'done');
                    });
            }
        ])->get();
        
        $outsideMissions = Person::where('is_force', 1)->whereHas('missions', function ($query){
            $query->where('category_id', 59)->whereHas('tasks', function ($query){
                $query->where('status', '<>', 'done');
            });
        })->orderBy('rank_id')->with([
            'rank',
            'missions' => function ($query){
                $query->where('category_id', 59)
                    ->whereHas('tasks', function ($query){
                        $query->where('status', '<>', 'done');
                    });
            }
        ])->get();

        $insideMissions = Person::whereHas('missions', function ($query){
            $query->where('category_id', 60)->whereHas('tasks', function ($query){
                $query->where('status', '<>', 'done');
            });
        })->orderBy('rank_id')->with([
            'rank',
            'missions' => function ($query){
                $query->where('category_id', 60)
                    ->whereHas('tasks', function ($query){
                        $query->where('status', '<>', 'done');
                    });
            }
        ])->get();

        return view('tanzim.show-persons')->with([
            'officers' => $officers,
            'subOfficers' => $subOfficers,
            'soliders' => $soldiers,
            'notForce' => $notForce,
            'ranks' => $ranks,
            'units' => $units,
            'specialities' => $specialities,
            'tamam' => $tamam,
            'ousideAttachedPeople' => $ousideAttachedPeople,
            'insideAttachedPeople' => $insideAttachedPeople,
            'outsideMissions' => $outsideMissions,
            'insideMissions' => $insideMissions,
        ]);
    }

    public function search(Request $request){
        $q = trim($request->search);

        $ar = explode(' ', $q);

        $result = Person::when($request->rank, fn ($query) =>
            $query->where('rank_id', $request->rank)
        )->where(function ($query) use ($ar){
            foreach($ar as $word){
                $query->where('name', 'like', "%$word%");
            }
        })->with('rank')->orderBy('rank_id')->get();

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
        $specialities = Speciality::orderBy('name')->get();
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
