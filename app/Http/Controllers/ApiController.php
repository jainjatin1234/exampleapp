<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

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
        'password'=> $req->password
       ]);

       if($user){
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data'=>$user
        ],Response::HTTP_OK);
       }
    }    
}
