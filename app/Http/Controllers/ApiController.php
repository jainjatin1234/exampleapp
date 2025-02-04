<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class ApiController extends Controller
{

    public function getuser(){
        return User::all();
    }

    public function register(Request $req)
    {
       $data =  $req->only('name','email','password');

       $validator = Validator::make($data, [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6'
       ]);

       if($validator->fails()){
        return response()->json(['error' => $validator->errors()],200);
       }

      $user =  User::create([
        'name'=> $req->name,
        'email'=> $req->email,
        'password'=> bcrypt($req->password)
       ]);

       if($user){
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'User created successfully',
            'data'=>$user
        ],Response::HTTP_OK);
       }else{
        return response()->json(['message' => 'Operation failed', 'code'=>500]); 
       }
    }    


    public function loginuser(Request $request){
        $credentials = $request->only('email','password');

        //valid credential
        $validator = Validator::make($credentials,[
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        //send failed response if request is not valid
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 200);
        }

        //request is validated
        //create token
        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'success' => false,
                    'message' => 'login credentials are invalid',
                    'code'=>400
                ]);
            }
        }catch(JWTException $e){
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'could not create token',
            ],500);
        }

        //token created, return with success response and get jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
            'code' => 201,
            'message' => 'login successfully',
            'user_details' => $credentials['email']
        ]);
    }
}
