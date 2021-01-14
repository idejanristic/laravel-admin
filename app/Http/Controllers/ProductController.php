<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    public function show($id) 
    {
        return new ProductResource(Product::find($id));
    }

    public function store(Request $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);

        $url = \Storage::disk('public')->putFileAs('images', $file, $name.'.'.$file->extension());

        $product = Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => env('APP_URL') .'/storage/'. $url,
            'price' => $request->input('price'),
        ]);

        return response($product, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id) 
    {
        
    }

    public function destroy($id) 
    {
        Product::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
