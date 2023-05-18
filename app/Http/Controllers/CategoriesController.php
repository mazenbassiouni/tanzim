<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function addCategory(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ],[
            'name.required' => 'يرجى إدخال النوع',
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'add category']);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect('category/'.$category->id);
    }

    public function showCategory(Request $request){
        $category = Category::findOrFail($request->id);

        return view('tanzim.category')->with([
            'category' => $category
        ]);
    }

    public function editCategory(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'categoryId' => 'required'
        ],[
            'name.required' => 'يرجى إدخال النوع',
        ]);
        
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with(['error_type' => 'edit category']);
        }

        $category = Category::findOrFail($request->categoryId);
        $category->name = $request->name;
        $category->save();

        return back();
    }

    public function deleteCategory(Request $request){
        $category = Category::findOrFail($request->categoryId);
        $category->delete();
        
        return redirect('missions/settings');
    }
}
