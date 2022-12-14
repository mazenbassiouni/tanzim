<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\Task;
use App\Models\Category;
use App\Models\CategoryTasks;
use Illuminate\Support\Facades\Validator;

class MissionsController extends Controller
{
    public function index(){
        $activeMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->where('tasks.status', 'active')
                    ->groupBy('missions.id')
                    ->select('missions.*')
                    ->selectRaw('MIN(tasks.due_to) as due_date')
                    ->orderBy('due_date')
                    ->get();

        $pendingMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->where('tasks.status', 'pending')
                    ->where(function($query){
                        $query->where('category_id','<>', 15)
                            ->where('category_id','<>', 17)
                            ->where('category_id','<>', 18);
                    })
                    ->whereNotExists(function($query){
                        $query->selectRaw(1)
                            ->from('tasks')
                            ->whereColumn('tasks.mission_id', '=', 'missions.id')
                            ->where('tasks.status', 'active');
                    })
                    ->groupBy('missions.id')
                    ->select('missions.*')
                    ->selectRaw('MIN(tasks.due_to) as due_date')
                    ->orderBy('tasks.created_at')
                    ->get();

        $doneMissions = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                    ->where('category_id', 1)
                    ->whereNotExists(function($query){
                        $query->selectRaw(1)
                            ->from('tasks')
                            ->whereColumn('tasks.mission_id', '=', 'missions.id')
                            ->where(function($query){
                                $query->where('tasks.status', 'pending')
                                    ->orWhere('tasks.status', 'active');
                            });
                    })
                    ->groupBy('missions.id')
                    ->select('missions.*')
                    ->selectRaw('MAX(tasks.due_to) as due_date')
                    ->orderBy('due_date')
                    ->get();

        $categories = Category::all();

        return view('tanzim.show-missions')->with([
            'activeMissions' => $activeMissions,
            'pendingMissions' => $pendingMissions,
            'doneMissions' => $doneMissions,
            'categories' => $categories
        ]);
    }

    public function addMission(Request $request){

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required_if:category_id,1',
            // 'desc' => 'required',
            'startedAt' => 'required',
            'categoryId' => 'required',
            'personId' =>'required_unless:categoryId,1'
        ],[
            'title.required_if' => '???????? ?????????? ??????????????',
            'desc.required' => '???????? ?????????? ??????????????',
            'startedAt.required' => '???????? ?????????? ?????????? ??????????',
            'personId.required_unless' => '???????? ?????????? ???????????? ???? ??????????'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'new mission']);
        }
    
        $mission                = new Mission();
        $mission->title         = $request->title;
        $mission->desc          = $request->desc;
        $mission->status        = 'active';
        $mission->started_at    = $request->startedAt;
        $mission->category_id   = $request->categoryId;
        if($request->category_id != 1 && isset($request->personId) ){
            $mission->person_id = $request->personId;
        }
        $mission->save();

        $extraTasks = CategoryTasks::whereCategoryId($mission->category_id)->orderBy('order')->get();

        foreach($extraTasks as $extraTask){
            $task                   = new Task();
            $task->mission_id       = $mission->id;
            $task->title            = $extraTask->title;
            $task->desc            = $extraTask->desc;
            $task->status           = $extraTask->status;
            $task->save();
        }

        return redirect('mission/'.$mission->id);
    }

    public function editMission(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required_if:category_id,1',
            // 'desc' => 'required',
            'startedAt' => 'required',
            'missionId' => 'required',
            'categoryId' => 'required',
            'personId' =>'required_unless:categoryId,1'
        ],[
            'title.required' => '???????? ?????????? ??????????????',
            'desc.required' => '???????? ?????????? ??????????????',
            'startedAt.required' => '???????? ?????????? ?????????? ??????????',
            'personId.required_unless' => '???????? ?????????? ???????????? ???? ??????????'
        ]);

        if($validator->fails()){
            // $request->error_type = 'edit mission';
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit mission']);
        }

        $mission = Mission::findOrFail($request->missionId);

        if($request->categoryId != 1 && isset($request->personId) ){
            $mission->title = '';
        }else{
            $mission->title = $request->title;
        }
        $mission->desc          = $request->desc;
        $mission->started_at    = $request->startedAt;
        $mission->category_id   = $request->categoryId;
        if($request->category_id != 1 && isset($request->personId) ){
            $mission->person_id = $request->personId;
        }
        $mission->save();

        return back();
    }

    public function deleteMission(Request $request){
        $mission = Mission::findOrFail($request->missionId);
        $mission->delete();
        if($request->headers->get('referer') == url('mission',$mission->id)){
            return redirect('/');
        }
        return back();
    }

    public function showMission(Request $request){
        $mission = Mission::findOrFail($request->id);
        $categories = Category::all();
        
        return view('tanzim.show-mission')->with([
            'mission' => $mission,
            'categories' => $categories
        ]);
    }

    public function showCouncils(Request $request){
        $sickCouncils = Mission::where('category_id', 3)->orderby('started_at', 'DESC')->get();

        $injuryCouncils = Mission::where('category_id', 9)->orderby('started_at', 'DESC')->get();

        $surgeryApprovals = Mission::where('category_id', 11)->orderby('started_at', 'DESC')->get();

        $categories = Category::all();

        return view('tanzim.show-councils')->with([
            'sickCouncils' => $sickCouncils,
            'injuryCouncils' => $injuryCouncils,
            'surgeryApprovals' => $surgeryApprovals,
            'categories' => $categories
        ]);
    }

    public function showInjuries(Request $request){
        $injuries = Mission::where('category_id', 2)->orderby('started_at', 'DESC')->get();

        $categories = Category::all();

        return view('tanzim.show-injuries')->with([
            'injuries' => $injuries,
            'categories' => $categories
        ]);
    }

    public function showMedicalCards(Request $request){
        $familyCards = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                        ->where('tasks.status', 'active')
                        ->where('category_id', 15)
                        ->groupBy('missions.id')
                        ->select('missions.*')
                        ->selectRaw('MIN(tasks.due_to) as due_date')
                        ->orderBy('due_date')
                        ->get();

        $parentCards = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
                        ->where('tasks.status', 'active')
                        ->where('category_id', 17)
                        ->groupBy('missions.id')
                        ->select('missions.*')
                        ->selectRaw('MIN(tasks.due_to) as due_date')
                        ->orderBy('due_date')
                        ->get();

        $categories = Category::all();

        return view('tanzim.show-cards')->with([
            'familyCards' => $familyCards,
            'parentCards' => $parentCards,
            'categories' => $categories
        ]);
    }
    
    public function showSquads(Request $request){
        $squads = Mission::where('category_id', 18)->orderby('started_at', 'DESC')->get();
        
        $categories = Category::all();
        
        return view('tanzim.show-squads')->with([
            'squads' => $squads,
            'categories' => $categories
        ]);
    }

    public function showEndServices(Request $request){
        $end_services = Mission::where('category_id', 10)->orderby('started_at', 'DESC')->get();
        
        $categories = Category::all();
        
        return view('tanzim.end-service')->with([
            'end_services' => $end_services,
            'categories' => $categories
        ]);
    }

    public function showInvestigations(Request $request){
        $investigations = Mission::where('category_id', 7)->orderby('started_at', 'DESC')->get();
        
        $categories = Category::all();
        
        return view('tanzim.investigations')->with([
            'investigations' => $investigations,
            'categories' => $categories
        ]);
    }
    
}
