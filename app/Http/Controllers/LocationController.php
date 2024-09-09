<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function list(){
        $location = Location::all();
        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $location
        ],200);
    }

    public function filterList($id){
        $location = Location::find($id);
        if(!$location){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $location
        ],200);
    }

    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'google_map' => 'string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $location = Location::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'location successfully created',
            'data' => $location
        ],200);
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required|string',
            'google_map' => 'string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $location = Location::find($id);
        if(!$location){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ],400);
        }

        $location->fill($data);
        $location->save();

        return response()->json([
            'status' => 'success',
            'message' => 'location successfully updated',
            'data' => $location
        ],200);
    }

    public function delete($id){
        $location = Location::find($id);
        if(!$location){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found',
            ],404);
        }

        $location->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'location successfully deleted'
        ],200);
    }
}
