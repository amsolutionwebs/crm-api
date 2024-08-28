<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendances;

class AttendanceController extends Controller
{
   public function checkInAttendance(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'check_in' => 'required',
        'check_by_id' => 'required',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

    // Check if attendance already exists for the user at the same check-in time
    $alreadyAttendance = Attendances::where('user_id', $request->user_id)
                                    ->where('check_in', $request->check_in)
                                    ->first();

    if ($alreadyAttendance) {
        return response()->json([
            'status' => false,
            'message' => 'Attendance already checked in',
            'errors' => 'Already exists'
        ], 403);
    }

    // Create a new Attendance instance and save it
    $attendance = new Attendances();
    $attendance->user_id = $request->user_id;
    $attendance->check_in = $request->check_in;
    $attendance->check_by_id = $request->check_by_id;
    $attendance->status = 'Present';
    $attendance->save();

    // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Attendance created successfully!'
    ], 200);
}

public function checkAttendanceAlready(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

    // Get the current date in the format Y-m-d
    $currentDate = now()->format('Y-m-d');

    // Check if attendance already exists for the user on the same date
    $alreadyAttendance = Attendances::where('user_id', $request->user_id)
                                    ->whereDate('check_in', $currentDate)
                                    ->first();

    if ($alreadyAttendance) {
        return response()->json([
            'status' => false,
            'message' => 'Attendance already checked in',
            'errors' => 'Already exists',
            'user' => 1
        ], 403);
    }

    // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Attendance not found!',
        'user' => 0
    ], 200);
}



}
