<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request){

        $request->validate([
           "name"=>"required|min:3",
           "email"=>"required|email|unique:users",
           "password"=>"required|min:8|confirmed"
        ]);

        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
        ]);

//        if(Auth::attempt($request->only(["email","password"]))){
//            $token=Auth::user()->createToken("phone")->plainTextToken;
//            return response()->json($token);
//        }

        return response()->json(["message"=>"User created!", "success" => true], 200);
    }

    public function login(Request $request){
        $request->validate([
            "email"=>"required|email|",
            "password"=>"required|min:8"
        ]);

        if(Auth::attempt($request->only(["email","password"]))){
            $token=Auth::user()->createToken("phone")->plainTextToken;
            return response()->json([
                "message"=>"Login successfully!",
                "success" => true,
                "token" => $token,
                "auth" => new UserResource(Auth::user())
            ], 200);
        }

        return response()->json(["message"=>"Login fail!"], 401);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
//        return response()->json(["logout successfully"], 204);

        return response()->json([
            "message"=>"Logout successfully!",
            "success" => true
        ], 200);
    }

    public function logoutAll(){
        Auth::user()->tokens()->delete();
        return response()->json(["logout all successfully"], 204);
    }

    public function tokens(){
        $tokens = Auth::user()->tokens;
        return response()->json($tokens);
    }
}
