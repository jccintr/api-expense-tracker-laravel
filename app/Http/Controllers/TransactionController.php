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
        $transactions = Transaction::with('category')->with('account')->where('user_id',Auth::User()->id)->get();
        return response()->json($transactions,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'description' => 'required',
            'amount' => 'required|gt:0',
            'category_id' => 'required|gt:0',
            'account_id' => 'required|gt:0',
        ]);

       // $input = $request->all();
       $description = $request->description;
       $amount = $request->amount;
       $category_id = $request->category_id;
       $account_id = $request->account_id;
       $user_id =  Auth::User()->id;

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
        $transaction = Transaction::with('category')->with('account')->find($id);
        if(!$transaction){
            return response()->json(['error'=>'Resource not found'],404);
        }

        if($transaction->user_id != Auth::User()->id){
            return response()->json(['error'=>'Access denied'],403);
        }

        return response()->json($transaction,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'description' => 'required',
            'amount' => 'required|gt:0',
            'category_id' => 'required|gt:0',
            'account_id' => 'required|gt:0',
        ]);

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
 
         
        $transaction->description = $description;
        $transaction->amount = $amount;
        $transaction->category_id = $category_id;
        $transaction->account_id = $account_id;
        
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
