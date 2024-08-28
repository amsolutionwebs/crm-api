<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Tags};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class TagController extends Controller
{
     public function createTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_name' => 'required',
            'status' => 'nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $tags = new Tags();


        $tags->tag_name = $request->tag_name;
        $tags->status = $request->status;
        $tags->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Tags created successfully!',
            'tags_id' => $tags->id
        ], 200);
    }

    // Update teamleader
    public function updateTag(Request $request)
    {
        // Find the existing Teamleader
        $Tags = Tags::find($request->id);

        if (!$Tags) {
            return response()->json([
                'status' => false,
                'message' => 'Tags not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'tag_name' => 'required',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Handle file upload
       

        // Update fields
        $Tags->tag_name = $request->get('tag_name', $Tags->tag_name);
        $Tags->status = $request->get('status', $Tags->status);
        $Tags->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Tag updated successfully!',
        ], 200);
    }

    // get all salesexecutives
    public function getTag()
    {
        $Tags = Tags::get();
        return response()->json([
            'status' => true,
            'message' => 'All Tags',
            'tags' => $Tags
        ], 200);
    }

    // get a specific teamleader
    public function getOneTag($id)
    {
        $tags = Tags::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Salesexecutives details',
            'tags' => $tags
        ], 200);
    }

    // delete a teamleader
    public function deleteTag($id)
    {
        $Tags = Tags::find($id);
        if (!$Tags) {
            return response()->json([
                'status' => false,
                'message' => 'Tags not found'
            ], 404);
        }
       
        $Tags->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tags deleted successfully'
        ], 200);
    }
}
