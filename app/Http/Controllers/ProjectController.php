<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Validator;

class ProjectController extends Controller
{
    public function list(Request $request): JsonResponse{
        $projects = Project::where('owner_id', '=', auth('sanctum')->user()->id)->get();
        //$projects = Project::all();
        $res = ['id' => auth('sanctum')->user()->id, 'projects' => $projects];
        return response()->json($res);
    }

    public function add(Request $request): JsonResponse{
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'project_description' => 'required',
        ]);


        if($validator->fails()){
            return response()->json(array('result' => 'fail'));
        }

        $project = Project::create([
           'project_name' => $request->input('project_name'), 
           'owner_id' => auth('sanctum')->user()->id, 
           'project_description' => $request->input('project_description'),
        ]);
        $project->save();
        return response()->json($project);
    }

    public function delete(Request $request): JsonResponse{
        $pID = $request->id;
        $pToDel = Project::where('owner_id', '=', auth('sanctum')->user()->id)->where('id', $pID)->firstOrFail();
        $pToDel->delete();
        return response()->json($this->list($request));
    }
}
