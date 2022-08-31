<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use Illuminate\Support\Facades\Validator;

class MissionsController extends Controller
{
    public function index(){
        $activeMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->where('tasks.status', 'active')
                    ->groupBy('missions.id', 'missions.title', 'missions.desc', 'missions.status', 'missions.started_at', 'missions.created_at', 'missions.updated_at')
                    ->select('missions.*')
                    ->selectRaw('MIN(tasks.due_to) as due_date')
                    ->orderBy('due_date')
                    ->get();

        $pendingMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->where('tasks.status', 'pending')
                    ->groupBy('missions.id', 'missions.title', 'missions.desc', 'missions.status', 'missions.started_at', 'missions.created_at', 'missions.updated_at')
                    ->select('missions.*')
                    ->selectRaw('MIN(tasks.due_to) as due_date')
                    ->orderBy('tasks.created_at')
                    ->get();

        $doneMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->whereNotExists(function($query){
                        $query->selectRaw(1)
                            ->from('tasks')
                            ->whereColumn('tasks.mission_id', '=', 'missions.id')
                            ->where(function($query){
                                $query->where('tasks.status', 'pending')
                                    ->orWhere('tasks.status', 'active');
                            });
                    })
                    ->groupBy('missions.id', 'missions.title', 'missions.desc', 'missions.status', 'missions.started_at', 'missions.created_at', 'missions.updated_at')
                    ->select('missions.*')
                    ->selectRaw('MAX(tasks.due_to) as due_date')
                    ->orderBy('due_date')
                    ->get();

        return view('missions.show-missions')->with([
            'activeMissions' => $activeMissions,
            'pendingMissions' => $pendingMissions,
            'doneMissions' => $doneMissions
        ]);
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
