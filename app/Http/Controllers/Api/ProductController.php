<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Http\Traits\ErrorMessage;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ErrorMessage;
    function index()
    {
        $products = Product::with('category')->orderBy('id', 'DESC')->get();
        return $this->sendResponse($products, 'Product Added successfully.');
    }
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $input = $request->all();
        $product = Product::create($input);
        return $this->sendResponse($product, 'Product Added successfully.');
    }
    function show(Request $request)
    {
        $product = Product::with('category')->find($request->id);
        if ($product) {
            return $this->sendResponse($product, 'Product Details');
        } else
            return $this->sendError('Error', 'Product Not Found', 404);
    }
    function productUpdae(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $product = Product::find($request->id);
        if ($product) {
            $product->update($request->only('name', 'price', 'category_id'));
            return $this->sendResponse($product, 'Product updated successfully');
        } else
            return $this->sendError('Error', 'Product Not Found', 404);
    }
    function productDelete(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product = Product::destroy($product->id);
            return $this->sendResponse($product, 'Product deleted successfully');
        }
        return $this->sendError('Error', 'Product Not Found', 404);
    }
}
