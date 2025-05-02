<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Credit_card;
use Illuminate\Http\Request;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $data=$request->validate([
                "user_id" => "numeric",
                "cardholder_name" => "required|string",
                "card_number" => "required|numeric|digits:16",
                "expiry_date"=>"required|string|max:5",
                "card_type"=>"required|string",
                "cvv"=>"required|numeric|digits:3"
    
            ]);
        
            $data["user_id"]= $user_id;
            // if($data["user_id"]===$user->id){
            if($data["user_id"]){
                $card=Credit_card::create($data);
                return response()->json(["message"=>"card added"],200);
            }else{ return response()->json(["message"=>"can't add by this user"],500);}
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }

    /**
     * Display the specified resource.
     */
    public function show(Credit_card $credit_card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
       //
    }

    public function remove_card_from_user(Request $request,$id)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $card=Credit_card::findOrFail($id);
            if($user_id===$card->user_id){

                $card->delete();
                return response()->json(["message"=>"card deleted"],200);
            }else{return response()->json(["message"=>"can't delete this card"],500);}

        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $cards= Credit_card::where("user_id", $user_id)->get();
            // return response()->json($carts,200);
            if(count($cards)<1){
                return response()->json(["message"=>"not found card"],500);
            }else{
                foreach($cards as $card):
                    $card->delete();
                endforeach;
            return response()->json(["message"=>"cards deleted"],200);
            }
        }
    }
}
