<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data=$request->validate([
        'name'=>'required|string|max:200',
        'email'=> 'required|email|unique:users',
        'password'=>'required|confirmed',
        "address"=>'required|string',
        "phone"=>'required|numeric|unique:users'
        ]);
        $user=User::create($data);

        return["go to login"];

        // $token = $user->createToken($request->name);
        // return [
        //     "user" =>$user,
        //     "token"=>$token->plainTextToken
        // ];
        
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required|email|exists:users',
            'password'=>'required'
        ]);

        $user= User::where('email',$request->email)->first();
        if(!$user | !Hash::check($request->password,$user->password)){
            return response()->json([
                "message" =>"email or password incorrect."
            ],500);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            "user"=>$user,
            "message"=> "login successful"
        ],200)->withCookie(
            cookie('auth_token', "$token", 60) // الكوكي سيكون HTTP-Only
        );

        
    }
    public function logout(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);

        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $tokens= PersonalAccessToken::where('tokenable_id',$user_id)->get();
            foreach ($tokens as $token) :
                $token->delete();
            endforeach;
            return response()->json(['message' => 'Logged out successfully'])
            ->withCookie(cookie()->forget('auth_token'));
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    

       
    }
   
}
