<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return["categories"=>$categories];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            "name" => "required|string|max:200",
            "description" => "required|string",
            "img"=>"required|image|mimes:jpg,png,jpeg,svg|max:2048"
        ]);
        // Category::create($data);
        // return["data"=>$data];

        $imagePath="";
        if($request->hasFile("img")){
            
            $image= $request->file("img");
            $imagename=time().".".$image->extension();
            $image->move(public_path("/storage/categoryImages/"), $imagename);
            $imagePath ="/storage/categoryImages/".$imagename;
            
        }

        $category=Category::create([
            "name"=> $data["name"],
            "description"=> $data["description"],
            "img"=>$imagePath
        ]);
        return [
            "message"=>"category is created",
            "created"=>$category
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return["category"=>$category];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data=$request->validate([
            "name" => "required|string|max:200",
            "description" => "required|string",
             ]);
        $category->update($data);  
        return [
            "massage" => "category is category",
            "category" => $data
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return ["message"=> "category is deleted"];
    }
}
