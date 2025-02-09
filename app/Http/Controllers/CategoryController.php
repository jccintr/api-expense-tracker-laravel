<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id',Auth::User()->id)->orderBy('name')->get();
        return response()->json($categories,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id =  Auth::User()->id;
        $name = $request->name;
       
        if(!$name){
         return response()->json(['error'=>'Bad request'],400);
        }

        $newCategory = new Category();
        $newCategory->name = $name;
        $newCategory->user_id = $user_id;
        $newCategory->save();
        return response()->json($newCategory,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->name;
        
        if(!$name){
            return response()->json(['error'=>'Bad request'],400);
        }

        $category = Category::find($id);
        if(!$category){
            return response()->json(['error'=>'Resource not found'],404);
        }
        
        if($category->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $category->name = $name;
        $category->save(); 

        return response()->json($category,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(['error'=>'Resource not found'],404);
        }

        if($category->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $category->delete();
        return response()->json(['message'=> "Resource deleted"],200);
    }
}
