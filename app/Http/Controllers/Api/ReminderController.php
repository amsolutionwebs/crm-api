<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reminders;
use Illuminate\Support\Facades\Validator;

class ReminderController extends Controller
{
      public function createreminder(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required',
            'date_time' => 'required',
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

        // Create a new Reminders instance and save it
        $Reminders = new Reminders();
        $Reminders->lead_id = $request->lead_id;
        $Reminders->date_time = $request->date_time;
        $Reminders->description = $request->description;
        $Reminders->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Reminders created successfully!'
        ], 200);
    }

   public function updatereminder(Request $request)
    {
       
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'lead_id' => 'required',
            'date_time' => 'required',
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

        // Find the Reminders record by id
        $Reminders = Reminders::find($request->id);

        // If Reminders record is not found, return error response
        if (!$Reminders) {
            return response()->json([
                'status' => false,
                'message' => 'Reminders not found'
            ], 404);
        }

        // Update Reminders record with new data
        $Reminders->lead_id = $request->lead_id;
        $Reminders->date_time = $request->date_time;
        $Reminders->description = $request->description;
        $Reminders->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Reminders updated successfully!'
        ], 200);
    }

      public function deletereminder(Request $request, $id)
{
    // Find the notice by ID
    $Reminders = Reminders::find($id);
    
    // Check if the notice exists
    if (!$Reminders) {
        return response()->json([
            'status' => false,
            'message' => 'Reminders not found'
        ], 404);
    }

    
    
    // Delete the notice from the database
    $Reminders->delete();
    
    return response()->json([
        'status' => true,
        'message' => 'Reminders deleted successfully'
    ], 200);
}


      public function getreminder(Request $request, $id)
{
    // Find the notice by ID
    $Reminders = Reminders::find($id);
    
    // Check if the notice exists
    if (!$Reminders) {
        return response()->json([
            'status' => false,
            'message' => 'Reminders not found'
        ], 404);
    }

    

    
    return response()->json([
        'status' => true,
        'message' => 'Reminders List',
        'Reminders' => $Reminders
    ], 200);
}
}
