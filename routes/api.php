<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CreditCardController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource("categories",CategoryController::class);
Route::apiResource("products",ProductController::class);

Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);
Route::get("logout",[AuthController::class,"logout"]);

Route::post("cart/add",[CartController::class,"add"]);
Route::get("cart",[CartController::class,"index"]);
Route::put("cart/update/{id}",[CartController::class,"update"]);
Route::delete("cart/remove/{id}",[CartController::class,"remove_from_cart"]);
Route::delete("cart/clear",[CartController::class,"clear"]);
Route::post("cart/checkout",[CartController::class,"checkout"]);
// Route::post("user/avatar",[AvatarController::class,"store"])->middleware("auth:sanctum");
Route::get("user/avatar",[UserController::class,"indexAvatar"]);
Route::post("user/avatar",[UserController::class,"updateAvatar"]);
Route::get("user/show",[UserController::class,"index"]);
Route::put("user/update",[UserController::class,"update"]);
Route::post("credit_card/add",[CreditCardController::class,"store"]);
Route::delete("credit_card/remove/{id}",[CreditcardController::class,"remove_card_from_user"]);
Route::delete("credit_card/clear",[CreditcardController::class,"destroy"]);




