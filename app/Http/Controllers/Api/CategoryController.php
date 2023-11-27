<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Traits\ErrorMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
class CategoryController extends Controller
{
    use ErrorMessage;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $input = $request->all();
        $Category = Category::create($input);
        return $this->sendResponse($Category, 'Category Added successfully.');
    }
}
