<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request){

        $validated_data = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(!empty($validated_data)){

            $user = User::where('email',$request->email)->first();

            if($request->email == $user->email){

                if(Hash::check($request->password , $user->password)){

                    return response()->json([
                        'message'=>'Login Successfull',
                        'status'=>200,
                        'token' => $user->createToken("api_token")->plainTextToken,
                        'user'=>$user,
                    ]);

                }else{
                    return response()->json([
                        'message'=>'invalid password',
                        'status'=>401,
                    ]);
                }

            }else{
                return response()->json([
                    'message'=>'invalid email',
                    'status'=>401,
                ]);
            }
        }else{

            return response()->json([
                'message'=>'invalid data',
                'status'=>401,
            ]);
        }

    }

    public function register(Request $request){

         $validated_data = $request->validate([
            'name'=>'required|string',
            'email'=>'required',
            'password'=>'required'
        ]);

        if($validated_data){
            
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password
            ]);

            return response()->json([
                'message'=>'User Created successfully',
                'status'=>200,
            ]);

        }else{

            return response()->json([
                'message'=>'invalid data',
                'status'=>401,
            ]);

        }

    }
}
