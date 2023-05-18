<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CategoryTasks;

class CategoriesTasksController extends Controller
{

    public function addTask(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'order' => 'required|integer',
            'categoryId' => 'required'
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'order.required' => 'يرجى إدخال الترتيب',
            'order.integer' => 'يرجى إدخال ترتيب صالح'
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'add task']);
        }

        $task = new CategoryTasks();
        $task->title = $request->title;
        $task->desc = $request->desc;
        $task->order = $request->order;
        $task->category_id = $request->categoryId;
        $task->status = 'pending';
        $task->save();

        return back();

    }

    public function editTask(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'order' => 'required|integer',
        ],[
            'title.required' => 'يرجى إدخال العنوان',
            'order.required' => 'يرجى إدخال الترتيب',
            'order.integer' => 'يرجى إدخال ترتيب صالح'
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit task']);
        }

        $task = CategoryTasks::findOrFail($request->taskId);
        $task->title = $request->title;
        $task->desc = $request->desc;
        $task->order = $request->order;
        $task->save();

        return back();
    }

    public function deleteTask(Request $request){
        $task =  CategoryTasks::findOrFail($request->taskId);
        $task->delete();

        return back();
    }
}
