<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'bail|required|string|min:3|max:255',
            'password' => [
            'required',
             Password::min(8) 
                ->letters()   
                ->mixedCase() 
                ->numbers()   
                ->symbols() ]
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $token = auth()->attempt($validator->validate());
        if(!$token){
            return response()->json(['error'=>'unauthorised']);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' =>'bearer',
            'expires_in' => auth()->factory()->getTTL()*60
        ]);

    }

    public function register(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required|string|min:3|max:255',
            'email' => 'bail|required|string|email|max:100|unique:users',
            'password' => [
            'required',
            'confirmed',
             Password::min(8) 
                ->letters()   
                ->mixedCase() 
                ->numbers()   
                ->symbols() ]]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password' =>Hash::make($request->password)
        ]);
        
        return response()->json(['message'=>'User Registered Successfully','user'=>$user],200);

    }

    public function profile(){
        return respose()->json(auth()->user);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message'=>'user has been succefully logged out']);
    }
}
