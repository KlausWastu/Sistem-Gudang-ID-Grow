<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function list(){
        $items = Item::all();

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $items
        ],200);
    }

    public function filterList($id){
        $item = Item::find($id);
        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $item
        ],200);
    }

    public function create(Request $request){
        $rules = [
            'code' => 'required|string',
            'item_name' => 'required|string',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'location_id' => 'required|integer',
            'image' => 'string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $item = Item::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'item successfully created',
            'data'=>$item
        ],200);
    }

    public function update(Request $request, $id){
        $rules = [
            'code' => 'required|string',
            'item_name' => 'required|string',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'location_id' => 'required|integer',
            'image' => 'string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $item = Item::find($id);
        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ],404);
        }

        $item->fill($data);
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'item successfully updated',
            'data' => $item
        ],200);
    }

    public function delete($id){
        $item = Item::find($id);

        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ],404);
        }

        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'item has been deleted'
        ]);
    }
}
