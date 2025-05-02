<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return["products"=>$products];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            "name" => "required|string|max:200",
            "description" => "required|string",
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
            "img"=>"required|image|mimes:jpg,png,jpeg,svg|max:2048"
        ]);

        $imagePath="";
        if($request->hasFile("img")){
            
            $image= $request->file("img");
            $imagename=time().".".$image->extension();
            $image->move(public_path("/storage/productImages/"), $imagename);
            $imagePath ="/storage/productImages/".$imagename;
            
        }

        $product=Product::create([
            "name"=> $data["name"],
            "description"=> $data["description"],
            "price"=> $data["price"],
            "category_id"=> $data["category_id"],
            "img"=>$imagePath
        ]);
        return [
            "message"=>"product is created",
            "created"=>$product
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ["product"=>$product];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data=$request->validate([
            "name" => "required|string|max:200",
            "description" => "required|string",
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
            "img"=>"required|image|mimes:jpg,png,jpeg,svg|max:2048"

        ]);

        $imagePath="";
        if($request->hasFile("img")){
            
            $image= $request->file("img");
            $imagename=time().".".$image->extension();
            $image->move(public_path("/storage/productImages/"), $imagename);
            $imagePath ="/storage/productImages/".$imagename;
            
        }

        $product->update([
            "name"=> $data["name"],
            "description"=> $data["description"],
            "price"=> $data["price"],
            "category_id"=> $data["category_id"],
            "img"=>$imagePath
        ]);
        return [
            "massage"=>"product updated",
            "product"=>$data
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return [
            "massage"=>"product deleted"
        ];
    }
}
