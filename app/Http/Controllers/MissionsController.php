<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use Illuminate\Support\Facades\Validator;

class MissionsController extends Controller
{
    public function index(){
        $missions = Mission::all();

        return view('missions.show-missions')->with(['missions' => $missions]);
    }

    public function addMission(Request $request){

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required',
            'startedAt' => 'required',
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'startedAt.required' => 'يرجى إدخال تاريخ البدء',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'new mission']);
        }
    
        $mission                = new Mission();
        $mission->title         = $request->title;
        $mission->desc          = $request->desc;
        $mission->status        = 'active';
        $mission->started_at    = $request->startedAt;
        $mission->save();

        return redirect('mission/'.$mission->id);
    }

    public function editMission(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required',
            'startedAt' => 'required',
            'missionId' => 'required'
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'startedAt.required' => 'يرجى إدخال تاريخ البدء',
        ]);

        if($validator->fails()){
            // $request->error_type = 'edit mission';
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit mission']);
        }

        $mission = Mission::findOrFail($request->missionId);

        $mission->title         = $request->title;
        $mission->desc          = $request->desc;
        $mission->started_at    = $request->startedAt;
        $mission->save();

        return back();
    }

    public function deleteMission(Request $request){
        $mission = Mission::findOrFail($request->missionId);
        $mission->delete();

        return back();
    }

    public function showMission(Request $request){
        $mission = Mission::findOrFail($request->id);
        
        return view('missions.show-mission')->with(['mission' => $mission]);
    }
}
