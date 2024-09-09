<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list(){
        $category = Category::all();
        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $category
        ],200);
    }

    public function filterList($id){
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $category
        ],200);
    }

    public function create(Request $request){
        $rules = [
            'name' => 'required|string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $category = Category::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'category successfully created',
            'data' => $category
        ],200);
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required|string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ],404);
        }

        $category->fill($data);
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'category successfully updated',
            'data' => $category
        ],200);
    }

    public function delete($id){
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ],404);
        }

        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'category successfully deleted',
        ],200);
    }
}
