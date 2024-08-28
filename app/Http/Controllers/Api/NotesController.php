<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notes;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    public function createNotes(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'notes_title' => 'required',
            'description' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Create a new Notes instance and save it
        $notes = new Notes();
        $notes->lead_id = $request->lead_id;
        $notes->notes_title = $request->notes_title;
        $notes->description = $request->description;
        $notes->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Notes created successfully!'
        ], 200);
    }

   public function updateNotes(Request $request)
    {
       
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'lead_id' => 'required',
            'notes_title' => 'required',
            'description' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Find the notes record by id
        $notes = Notes::find($request->id);

        // If notes record is not found, return error response
        if (!$notes) {
            return response()->json([
                'status' => false,
                'message' => 'Notes not found'
            ], 404);
        }

        // Update notes record with new data
        $notes->lead_id = $request->lead_id;
        $notes->notes_title = $request->notes_title;
        $notes->description = $request->description;
        $notes->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Notes updated successfully!'
        ], 200);
    }

      public function deleteNotes(Request $request, $id)
{
    // Find the notice by ID
    $Notes = Notes::find($id);
    
    // Check if the notice exists
    if (!$Notes) {
        return response()->json([
            'status' => false,
            'message' => 'Notes not found'
        ], 404);
    }

    
    
    // Delete the notice from the database
    $Notes->delete();
    
    return response()->json([
        'status' => true,
        'message' => 'Notes deleted successfully'
    ], 200);
}


      public function getNotes(Request $request, $id)
{
    // Find the notice by ID
    $Notes = Notes::find($id);
    
    // Check if the notice exists
    if (!$Notes) {
        return response()->json([
            'status' => false,
            'message' => 'Notes not found'
        ], 404);
    }

    

    
    return response()->json([
        'status' => true,
        'message' => 'Notes List',
        'Notes' => $Notes
    ], 200);
}

}
