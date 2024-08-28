<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Projects,Customers};
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class ProjectController extends Controller
{
    public function createProject(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'project_name' => 'required|string|max:255',
            'price' => 'required|string',
            'deadline' => 'required',
            'requirement_type' => 'nullable',
            'requirement' => 'nullable',
            'refferal_website' => 'nullable',
            'refferal_app' => 'nullable|string|max:255',
            'screenshot' => 'nullable',
            'project_status' => 'nullable',
            'status' => 'nullable'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $projects = new Projects();

        if (isset($request->screenshot)) {
        $imageName = time() . '.' . $request->screenshot->extension();
        $request->screenshot->move(public_path('upload'), $imageName);
            $projects->screenshot = $imageName;
        }

        $projects->customer_id = $request->customer_id;
        $projects->project_name = $request->project_name;
        $projects->price = $request->price;
        $projects->deadline = $request->deadline;
        $projects->requirement_type = $request->requirement_type;
        $projects->requirement = $request->requirement;
        $projects->refferal_website = $request->refferal_website;
        $projects->refferal_app = $request->refferal_app;
        $projects->project_status = $request->project_status;
        $projects->status = $request->status;
        $projects->save();
         // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Project created successfully!'
        ], 200);

    }

    // update project
    public function updateProject(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'id' => 'required',
            'customer_id' => 'required|exists:customers,id',
            'project_name' => 'required|string|max:255',
            'price' => 'required|string',
            'deadline' => 'required',
            'requirement_type' => 'nullable',
            'requirement' => 'nullable',
            'refferal_website' => 'nullable',
            'refferal_app' => 'nullable|string|max:255',
            'screenshot' => 'nullable',
            'project_status' => 'nullable',
            'status' => 'nullable'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $projects = Projects::where('id',$request->id)->first();

        if (isset($request->screenshot)) {
        $imageName = time() . '.' . $request->screenshot->extension();
        $request->screenshot->move(public_path('upload'), $imageName);
            $projects->screenshot = $imageName;
        }

        $projects->customer_id = $request->customer_id;
        $projects->project_name = $request->project_name;
        $projects->price = $request->price;
        $projects->deadline = $request->deadline;
        $projects->requirement_type = $request->requirement_type;
        $projects->requirement = $request->requirement;
        $projects->refferal_website = $request->refferal_website;
        $projects->refferal_app = $request->refferal_app;
        $projects->project_status = $request->project_status;
        $projects->status = $request->status;
        $projects->save();
         // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Project details updated successfully!'
        ], 200);

    }

    // get project 
    public function getProject()
    {
         $project = Projects::get(); 
         return response()->json([
        'status' => true,
        'message' => 'All Project',
        'project' => $project
    ], 200);
    }

    // delete project
    public function deleteProject($id)
    {
        // Find the project by id
        $project = Projects::find($id);

        // Check if the project exists
        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found'
            ], 404);
        }

        // Define the image path
        $imagePath = public_path('upload') . '/' . $project->screenshot;

        // Check if the file exists and delete it
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete the project
        $project->delete();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Project details removed successfully'
        ], 200);
    }

    // update project status
    public function updateProjectStatus(Request $request)
    {
        $projects = Projects::where('id',$request->id)->first();
        $projects->project_status = $request->project_status;
        $projects->save();

        return response()->json([
            'status' => true,
            'message' => 'Project status successfully updated'
        ], 200);
    }


}
