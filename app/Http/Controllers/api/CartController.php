<?php

namespace App\Http\Controllers\api;
use App\Models\Cart;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $cart = Cart::where("user_id", $user_id)->get();
            if($cart->isEmpty()){
                return response()->json(['message' => 'Cart not found'], 404);}else{
            return response()->json($cart);
                }
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

    //
        // $data= cart::all();
        // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id = $accessToken->tokenable_id;
            $data=$request->validate([
                "user_id" => "numeric",
                "product_id" => "required|numeric",
                "quantity" => "required|numeric|max:10",
            ]);
            $data["user_id"]= $user_id;
            $cart=Cart::create($data);
            return [
            "message"=>"cart added",
            ];

        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data=$request->validate([
            "quantity" => "required|numeric|max:10"
        ]);
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id= $accessToken->tokenable_id;

            $cart = Cart::where("id", $id)->first();

            // dd([
            //     'Auth User ID' => $user->id,
            //     'Cart ' => $cart->user_id
            // ]);
            if($user_id === $cart->user_id){
        
                $cart->update($data);
                return response()->json([
                    "message" => "Quantity updated"
                ], 200);
            }else{ return response()->json(["message"=> "You don't have permission to update this cart"],403);}
        
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

        
    }

    public function remove_from_cart(Request $request,$id)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id= $accessToken->tokenable_id;
            $cart = Cart::where("id", $id)->first();

            $cart=Cart::findOrFail($id);
            if($user_id ===$cart->user_id){

                $cart->delete();
                return response()->json(["message"=>"cart deleted"],200);
            }else{return response()->json(["message"=>"can't delete this cart"],500);}

        }else{return response()->json(["message"=>"cookie Expire"],500) ;}

    }

    public function checkout(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user_id= $accessToken->tokenable_id;
            $carts= cart::where("user_id", $user_id)->get();
            // return response()->json($carts,200);
            if(count($carts)<1){
                return response()->json(["message"=>"not found any carts"],500);
            }else{
                foreach($carts as $cart):
                    $cart->delete();
                endforeach;
            return response()->json(["message"=>"carts deleted"],200);
            }
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }

       
    
    public function clear(Request $request)
    {
        $token = urldecode($request->cookie('auth_token')); // فك تشفير التوكن من الكوكيز
        $accessToken = PersonalAccessToken::findToken($token);
        if($accessToken){
        $carts= cart::all();
        // return response()->json($carts,200);
        if(count($carts)<1){
            return response()->json(["message"=>"not found any carts"],500);
        }else{
            foreach($carts as $cart):
                $cart->delete();
            endforeach;
        return response()->json(["message"=>"cart deleted"],200);
        }
        }else{return response()->json(["message"=>"cookie Expire"],500) ;}
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        
    }
}
