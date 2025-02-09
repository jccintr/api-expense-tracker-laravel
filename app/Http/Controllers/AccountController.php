<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $accounts = Account::where('user_id',Auth::User()->id)->orderBy('name')->get();
        return response()->json($accounts,200);
    
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

       $newAccount = new Account();
       $newAccount->name = $name;
       $newAccount->user_id = $user_id;
       $newAccount->save();
       return response()->json($newAccount,201);
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

        $account = Account::find($id);
        if(!$account){
            return response()->json(['error'=>'Resource not found'],404);
        }
        
        if($account->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $account->name = $name;
        $account->save(); 

        return response()->json($account,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $account = Account::find($id);
        if(!$account){
            return response()->json(['error'=>'Resource not found'],404);
        }

        if($account->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $account->delete();
        return response()->json(['message'=> "Resource deleted"],200);
        
    }
}
