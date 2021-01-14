<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;
use App\Http\Resources\ProductResource;

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
