<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Mutation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MutationController extends Controller
{
    public function list(){
        $mutations = Mutation::all();

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $mutations
        ],200);
    }

    public function filterList($id){
        $mutation = Mutation::find($id);
        if(!$mutation){
            return response()->json([
                'status' => 'error',
                'message' => 'data not found'
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data found',
            'data' => $mutation
        ],200);
    }

    public function create(Request $request){
        $rules = [
            'date' => 'required|date',
            'type_mutation' => 'required|in:pemindahan,pengurangan,penambahan',
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
            'amount' => 'integer',
            'start_location' => 'integer',
            'end_location' => 'integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $itemId = $request->input('item_id');
        $item = Item::find($itemId);
        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'item not found'
            ], 404);
        }

        $userId = $request->input('user_id');
        $user = User::find($userId);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found',
            ], 404);
        }

        $amount = $request->input('amount');
        $typeMutation = $request->input('type_mutation');
        if($typeMutation === 'pengurangan'){
            $item = Item::find($itemId);
            if($item->stock < $amount){
                return response()->json([
                    'status' => 'error',
                    'message' => 'stock insufficient, please restock first!',
                ], 400);
            } else {
                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'berhasil update item',
                // ], 200);
                $item->stock -= $amount;
                $item->save();
            }
        } else if($typeMutation === 'penambahan'){
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'berhasil update item',
            // ], 200);
            $item->stock += $amount;
            $item->save();
        } else if($typeMutation === 'pemindahan') {
            $startLocation = $request->input('start_location');
            $destinationLocation = $request->input('end_location');
            $startItem = Item::where('id', $itemId)
                         ->where('location_id', $startLocation)
                         ->first();
            $checkDestinationLocationOnDatabase = Item::where('location_id', $destinationLocation)
                         ->first();
            if(!$checkDestinationLocationOnDatabase){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Location not added yet'
                ], 404);
            } else {
                if(!$startItem){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Item not found at that location'
                    ], 404);
                } else {
                    $destinationCodeItem = $startItem->code;
                    $destinationItem = Item::where('code', $destinationCodeItem)
                             ->where('location_id', $destinationLocation)->first();
                    if(!$destinationItem){
                        // $newItem = Item::create($data);
                        $newItem = $startItem->replicate();
                        $newItem->location_id = $destinationLocation;
                        $newItem->stock = $amount;
                        $newItem->save();
                        $item->stock -= $amount;
                        $item->save();

                        // return response()->json([
                        //     'status' => 'error',
                        //     'message' => 'Item tidak ditemukan pada lokasi tujuan'
                        // ], 404);
                    } else {
                        $destinationItem->stock += $request->input('amount');
                        $destinationItem->save();

                        $item->stock -= $amount;
                        $item->save();
                        // return response()->json([
                        //     'status' => 'success',
                        //     'message' => 'Item ditemukan pada lokasi tujuan'
                        // ], 200);
                    }
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => 'Item ditemukan pada lokasi tersebut'
                    // ], 200);
                }
            }

        }

        $mutation = Mutation::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'mutation successfully created',
            'data_item' => $newItem ?? $item,
            'data_mutation' => $mutation
        ], 200);
    }

    public function update(Request $request, $id){
        $rules = [
            'date' => 'required|date',
            'type_mutation' => 'required|in:pemindahan,pengurangan,penambahan',
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
            'amount' => 'integer',
            'start_location' => 'integer',
            'end_location' => 'integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $mutation = Mutation::find($id);
        if(!$mutation){
            return response()->json([
                'status' => 'error',
                'message' => 'mutation not found'
            ], 404);
        }

        $itemId = $request->input('item_id');
        $item = Item::find($itemId);
        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'item not found'
            ], 404);
        }

        $userId = $request->input('user_id');
        $user = User::find($userId);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found',
            ], 404);
        }

        $itemId = $request->input('item_id');
        $item = Item::find($itemId);
        if(!$item){
            return response()->json([
                'status' => 'error',
                'message' => 'item not found'
            ], 404);
        }

        $userId = $request->input('user_id');
        $user = User::find($userId);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found',
            ], 404);
        }

        $amount = $request->input('amount');
        $typeMutation = $request->input('type_mutation');
        if($typeMutation === 'pengurangan'){
            $item = Item::find($itemId);
            if($item->stock < $amount){
                return response()->json([
                    'status' => 'error',
                    'message' => 'stock insufficient, please restock first!',
                ], 400);
            } else {
                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'berhasil update item',
                // ], 200);
                $item->stock -= $amount;
                $item->save();
            }
        } else if($typeMutation === 'penambahan'){
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'berhasil update item',
            // ], 200);
            $item->stock += $amount;
            $item->save();
        } else if($typeMutation === 'pemindahan') {
            $startLocation = $request->input('start_location');
            $destinationLocation = $request->input('end_location');
            $startItem = Item::where('id', $itemId)
                         ->where('location_id', $startLocation)
                         ->first();
            if(!$startItem){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item tidak ditemukan pada lokasi tersebut'
                ], 404);
            } else {
                $destinationCodeItem = $startItem->code;
                $destinationItem = Item::where('code', $destinationCodeItem)
                         ->where('location_id', $destinationLocation)->first();
                if(!$destinationItem){
                    // $newItem = Item::create($data);
                    $newItem = $startItem->replicate();
                    $newItem->location_id = $destinationLocation;
                    $newItem->stock = $amount;
                    $newItem->save();
                    $item->stock -= $amount;
                    $item->save();

                    // return response()->json([
                    //     'status' => 'error',
                    //     'message' => 'Item tidak ditemukan pada lokasi tujuan'
                    // ], 404);
                } else {
                    $destinationItem->stock += $request->input('amount');
                    $destinationItem->save();

                    $item->stock -= $amount;
                    $item->save();
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => 'Item ditemukan pada lokasi tujuan'
                    // ], 200);
                }
                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'Item ditemukan pada lokasi tersebut'
                // ], 200);
            }
        }

        $mutation->fill($data);
        $mutation->save();

        return response()->json([
            'status' => 'success',
            'message' => 'mutation successfully updated',
            'data_item' => $newItem ?? $item,
            'data_mutation' => $mutation
        ], 200);
    }

    public function delete($id){
        $mutation = Mutation::find($id);
        if(!$mutation){
            return response()->json([
                'status' => 'error',
                'message' => 'mutation not found'
            ], 404);
        }

        $mutation->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'mutation has been deleted'
        ], 200);
    }

    public function showByItem($id){
        $mutations = Mutation::where('item_id', $id)->get();
        if(!$mutations){
            return response()->json([
                'status' => 'error',
                'message' => 'Mutation with the specified item was not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Mutation with the specified item was found',
            'data' => $mutations
        ], 200);
    }

    public function showByUser($id){
        $mutations = Mutation::where('user_id', $id)->get();
        if(!$mutations){
            return response()->json([
                'status' => 'error',
                'message' => 'Mutation with the specified user was not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Mutation with the specified user was found',
            'data' => $mutations
        ], 200);
    }
}
