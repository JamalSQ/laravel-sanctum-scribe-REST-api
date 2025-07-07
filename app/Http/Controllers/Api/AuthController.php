<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * User login.
     *
     * Authenticates a user and returns an API token.
     *
     * @group Authentication
     * @bodyParam email string required The user email.
     * @bodyParam password string required The user password (minimum 8 characters, at least one letter and one digit).
     *
     * @response 200 {
     *   "message": "Login successful",
     *   "status": 200,
     *   "token": "lkasfjkls234534587asf",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com"
     *   }
     * }
     *
     * @response 401 {
     *   "message": "Invalid credentials",
     *   "status": 401
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
     */
    public function login(Request $request)
    {
        $validated_data = $request->validate([
            'email'=>'email',
            'password'=>'required'
        ]);

        if(!empty($validated_data)){

            $user = User::where('email',$request->email)->first();
            
            if(!empty($user->email)){

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
                'message'=>'Validation failed',
                'status'=>422,
            ]);
        }

    }

    /**
     * User registration.
     *
     * Registers a new user and returns a success message.
     *
     * @group Authentication
     * @bodyParam name string required The user name.
     * @bodyParam email string required The user email.
     * @bodyParam password string required The password (minimum 8 characters, at least one letter and one digit).
     *
     * @response 201 {
     *   "message": "User created successfully",
     *   "status": 201
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {
     *     "email": ["The email has already been taken."],
     *     "password": ["The password must be at least 8 characters."]
     *   }
     * }
     */
    public function register(Request $request)
    {
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
