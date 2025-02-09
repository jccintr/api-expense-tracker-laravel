<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class AccountController extends Controller
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
       $description = $request->description;
       if(!$name or !$description){
        return response()->json(['erro'=>'Bad request'],400);
       }
       $newCategory = new Category();
       $newCategory->name = $name;
       $newCategory->description = $description;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
