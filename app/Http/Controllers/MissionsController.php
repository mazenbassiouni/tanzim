<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\Task;
use App\Models\Category;
use App\Models\CategoryTasks;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\Functions;

class MissionsController extends Controller
{
    use Functions;

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
                    ->selectRaw('MAX(tasks.done_at) as done_at')
                    ->orderByDesc('done_at')
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
                    ->selectRaw('MAX(tasks.done_at) as done_at')
                    ->orderByDesc('done_at')
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
            'title.required_if' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'startedAt.required' => 'يرجى إدخال تاريخ البدء',
            'personId.required_unless' => 'يرجى تحديد الضابط أو الفرد'
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
            'title.required' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'startedAt.required' => 'يرجى إدخال تاريخ البدء',
            'personId.required_unless' => 'يرجى تحديد الضابط أو الفرد'
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

        $sickCouncils = $this->missionsCollection(3);
        $injuryCouncils = $this->missionsCollection(9);
        $surgeryApprovals = $this->missionsCollection(11);

        $categories = Category::all();

        return view('tanzim.show-councils')->with([
            'sickCouncils' => $sickCouncils,
            'injuryCouncils' => $injuryCouncils,
            'surgeryApprovals' => $surgeryApprovals,
            'categories' => $categories
        ]);
    }

    public function showInjuries(Request $request){
        $injuries = $this->missionsCollection(2);

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
        // $end_services = Mission::where('category_id', 10)->orderby('started_at', 'DESC')->get();
        $end_services = $this->missionsCollection(10);
        $categories = Category::all();
        
        return view('tanzim.end-service')->with([
            'end_services' => $end_services,
            'categories' => $categories
        ]);
    }

    public function showInvestigations(Request $request){
        $investigations = $this->missionsCollection(7);
        
        $categories = Category::all();
        
        return view('tanzim.investigations')->with([
            'investigations' => $investigations,
            'categories' => $categories
        ]);
    }

    public function showAttachments(Request $request){
        $insideAttach = $this->missionsCollection(20);
        $outsideAttach = $this->missionsCollection(21);

        $categories = Category::all();
        
        return view('tanzim.attachments')->with([
            'outsideAttach' => $outsideAttach,
            'insideAttach' => $insideAttach,
            'categories' => $categories
        ]);
    }

    public function showAppendices(Request $request){
        $appendices = Mission::where( function ($query){
            $query->where('category_id',20)
               ->orWhere('category_id',21);
        })->whereHas('tasks', function ($query){
            $query->where('status','active');
        })->with('tasks')->orderby('tasks.duo_to', 'DESC')->get();   

        dd($appendices->toArray());
    }
    
}
