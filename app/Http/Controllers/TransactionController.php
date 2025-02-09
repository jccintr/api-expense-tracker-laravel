<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id',Auth::User()->id)->get();
        return response()->json($transactions,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // $input = $request->all();
       $description = $request->description;
       $amount = $request->amount;
       $category_id = $request->category_id;
       $account_id = $request->account_id;
       $user_id =  Auth::User()->id;

       if(!$description or !$amount or !$category_id or !$account_id){
        return response()->json(['error'=>'Bad request'],400);
       }
       if($amount <=0){
         return response()->json(['error'=>'Field amount must be greater then zero'],400);
       }


       $newTransaction = new Transaction();
       $newTransaction->description = $description;
       $newTransaction->amount = $amount;
       $newTransaction->category_id = $category_id;
       $newTransaction->account_id = $account_id;
       $newTransaction->user_id = $user_id;
       $newTransaction->save();
       return response()->json($newTransaction,201);
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

        $transaction = Transaction::find($id);
        if(!$transaction){
            return response()->json(['error'=>'Resource not found'],404);
        }

        if($transaction->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $description = $request->description;
        $amount = $request->amount;
        $category_id = $request->category_id;
        $account_id = $request->account_id;
        $user_id =  Auth::User()->id;
 
        if(!$description or !$amount or !$category_id or !$account_id){
         return response()->json(['error'=>'Bad request'],400);
        }
        if($amount <=0){
          return response()->json(['error'=>'Field amount must be greater then zero'],400);
        }

      
        $transaction->description = $description;
        $transaction->amount = $amount;
        $transaction->category_id = $category_id;
        $transaction->account_id = $account_id;
        $transaction->user_id = $user_id;
        $transaction->save();
        return response()->json($transaction,200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        if(!$transaction){
            return response()->json(['error'=>'Resource not found'],404);
        }

        if($transaction->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        $transaction->delete();
        return response()->json(['message'=> "Resource deleted"],200);
    }
}
