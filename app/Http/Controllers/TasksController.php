<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Mission;

class TasksController extends Controller
{
    public function addTask(Request $request){

        $mission = Mission::findOrFail($request->missionId);

        $task                   = new Task();
        $task->mission_id       = $mission->id;
        $task->title            = $request->title;
        $task->desc             = $request->desc;
        $task->due_to           = $request->dueTo;
        $task->status           = $request->status;
        $task->save();

        return back();
    }

    public function editTask(Request $request){
        $task = Task::findOrFail($request->taskId);

        $task->title            = $request->title;
        $task->desc             = $request->desc;
        $task->due_to           = $request->dueTo;
        if( isset($request->status) ){
            $task->status           = $request->status;
        }
        $task->save();

        return back();

    }

    public function deleteTask(Request $request){
        $task = Task::findOrFail($request->taskId);
        $task->delete();

        return back();
    }

    public function setTaskAsDone(Request $request){
        $task = Task::findOrFail($request->taskId);
        
        $task->status = 'done';
        $task->save();

        return back();
    }
}
