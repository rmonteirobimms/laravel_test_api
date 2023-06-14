<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    //Returns all the products available
    public function index(){
        return Product::all();
    }

    //Returns all the products available
    public function search($query){
        return Product::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('description', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%')
                        ->get();
    }

    //Returns specific product
    public function show($id){
        return Product::find($id);
    }

    //Creates new product
    public function store(ProductRequest $request){
        $product = $request->validated();
        return Product::create($product);
    }

    //Update given product
    public function update(ProductRequest $request, $id){
        $updatedInfo = $request->validated();
        $product = self::show($id);

        return $product -> update($updatedInfo);
    }

    //Destroy specific product
    public function destroy($id){
        return Product::destroy($id);
    }
    
}
