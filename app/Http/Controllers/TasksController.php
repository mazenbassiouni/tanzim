<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Mission;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TasksController extends Controller
{
    public function addTask(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            // 'desc' => 'required',
            'status' => 'required',
            'dueTo' => 'required_if:status,active',
            'missionId' => 'required'
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'dueTo.required_if' => 'يرجى إدخال التاريخ ',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'new task']);
        }

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
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            // 'desc' => 'required',
            'dueTo' => 'required_if:status,active',
            'taskId' => 'required'
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'desc.required' => 'يرجى إدخال الموضوع',
            'dueTo.required_if' => 'يرجى إدخال التاريخ ',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit task']);
        }

        $task = Task::findOrFail($request->taskId);

        $task->title            = $request->title;
        $task->desc             = $request->desc;
        if( isset($request->dueTo) ){
            $task->due_to           = $request->dueTo;
        }
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
        $task->done_at = $request->done_at ?? Carbon::now();
        $task->save();

        return back();
    }
}
