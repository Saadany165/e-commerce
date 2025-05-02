<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAvatar(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if($accessToken){
            $user_id= $accessToken->tokenable_id;
            $avatars=User::all()->where("id",$user_id)->first();
            return response()->json($avatars->avatar,200);
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

    }

    public function index(Request $request)
    {
        
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if($accessToken){
            $user_id= $accessToken->tokenable_id;
            $avatars=User::all()->where("id",$user_id)->first();
            return response()->json($avatars,200);
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

    }



    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data=$request->validate([
    //         "user_id"=>"numeric",
    //         "avatar"=>"required|image|mimes:jpg,png,jpeg,svg|max:2048"
    //     ]);
    //     $user = Auth::user();
    //     $data["user_id"]=$user->id;

    //     $avatarPath="";
    //     if($request->hasFile("avatar")){
            
    //         $avatar= $request->file("avatar");
    //         $avatarname=time().".".$avatar->extension();
    //         $avatar->move(public_path("/storage/userAvatars/"), $avatarname);
    //         $avatarPath ="/storage/userAvatars/".$avatarname;
            
    //     }

    //     //لحذف الصورة اللي قبلها 
    //     $avatars=Avatar::all()->where("user_id",$user->id)->first()->delete();

    //     $avatar=Avatar::create([
    //         "user_id"=> $data["user_id"],
    //         "avatar"=>$avatarPath
    //     ]);
    //     return [
    //         "message"=>"avatar is created",
    //         "created"=>$avatar
    //     ];
    // }

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
    public function updateAvatar(Request $request)
    {
        $data=$request->validate([
            // "user_id"=>"numeric",
            "avatar"=>"required|image|mimes:jpg,png,jpeg,svg|max:2048"
        ]);

        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if($accessToken){
            $user_id= $accessToken->tokenable_id;

            //$data["user_id"]=$user_id;

            $avatarPath="";
            if($request->hasFile("avatar")){
            
                $avatar= $request->file("avatar");
                $avatarname=time().".".$avatar->extension();
                $avatar->move(public_path("/storage/userAvatars/"), $avatarname);
                $avatarPath ="/storage/userAvatars/".$avatarname;
            
            }

            //لحذف الصورة اللي قبلها 
            // $avatars=Avatar::all()->where("user_id",$user->id)->first()->delete();

            $avatar=User::where('id', $user_id)->update([
                "avatar"=>$avatarPath
            ]);
            return [
                "message"=>"avatar is updated",
                "created"=>$avatar
            ];
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }


    public function update(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if($accessToken){
            $user_id= $accessToken->tokenable_id;
            $user= User::all()->where("id",$user_id)->first();

            $data=$request->validate([
                "name"=>'required|string|max:200',
                "email"=> "required|email|unique:users,email,{$user->id}",
                "phone"=> "required|numeric|unique:users,phone,{$user->id}",
                "address"=>'required|string'
           
            ]);
            $user->update($data);
             return [
                "message"=>"user is updated",
                "created"=>$data
            ];
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
