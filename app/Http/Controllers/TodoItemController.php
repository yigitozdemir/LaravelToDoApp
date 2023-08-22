<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TodoItem;
use App\Models\User;
use App\Models\Project;
use Validator;

class TodoItemController extends Controller
{
    public function list(Request $request): JsonResponse{
        $pID = $request->project_id;
        $project = Project::where('owner_id', '=', auth('sanctum')->user()->id)->where('id', $pID)->firstOrFail();
        $items = TodoItem::where('project_id', '=', $project->id)->get();
        return response()->json($items);
    }

    public function add(Request $request): JsonResponse{
        $pID = $request->project_id;
        $project = Project::where('owner_id', '=', auth('sanctum')->user()->id)->where('id', $pID)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'item_title' => 'required',
            'item_description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(array('result' => 'fail'));
        }

        $item = TodoItem::create([
            'project_id' => $pID,
            'item_title' => $request->input('item_title'),
            'item_description' => $request->input('item_description'),
            'item_status' => TRUE,
        ]);
        $item->save();
        return response()->json($item);
    }

    public function change_status(Request $request): JsonResponse{
        $iID = $request->item;
        $status = $request->status;

        $itemToUpdate = TodoItem::where('id', '=', $iID)->firstOrFail();
        $project = Project::where('id', '=', $itemToUpdate->project_id)->where('owner_id', '=', auth('sanctum')->user()->id)->firstOrFail();
        

        $itemToUpdate->item_status = $status;
        $itemToUpdate->save();
        return response()->json($itemToUpdate);
    }

    public function delete(Request $request): JsonResponse{
        $iID = $request->item;

        $itemToUpdate = TodoItem::where('id', '=', $iID)->firstOrFail();
        $project = Project::where('id', '=', $itemToUpdate->project_id)->where('owner_id', '=', auth('sanctum')->user()->id)->firstOrFail();
        

        $itemToUpdate->delete();
        //$itemToUpdate->save();
        return response()->json(array('result' => 'success'));
    }
}
