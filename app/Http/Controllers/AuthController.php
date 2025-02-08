<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  
   
    public function register(Request $request)
    {
        $name = $request->name;
        $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
        $password = $request->password;

        $user = User::select()->where('email', $email)->first();
        if($user) {
            $array['erro'] = "Email já cadastrado.";
            return response()->json($array,400);
        }

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = Hash::make($password);
        $newUser->save();
        return response()->json($newUser,201);
    }

    public function login(Request $request)
    {
        $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
        $password = $request->password;
 
        $credentials = ['email'=> $email,'password'=>$password];

        //verifica se o email existe
        if (!Auth::attempt($credentials)) {
            return response()->json(['erro'=>'Email e ou senha inválidos'],401);
        }

        $token = Auth::User()->createToken('expense-tracker');
        return response()->json(['token'=>$token->plainTextToken],201); 
      
    }



}
