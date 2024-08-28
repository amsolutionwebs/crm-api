<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Seniorsalesofficers, Salesexecutives, Employee_ids};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class SalesExecutiveController extends Controller
{
     public function createSalesexecutive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seniorsalesofficer_id' => 'required|exists:seniorsalesofficers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:salesexecutives,email|max:255',
            'mobile_number' => 'required|numeric|unique:salesexecutives,mobile_number',
            'marital_status' => 'required',
            'qualification' => 'nullable|integer',
            'designation' => 'nullable|integer',
            'blood_group' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'adhar_card_front_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'adhar_card_back_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'bio' => 'nullable|string',
            'username' => 'nullable|string|unique:salesexecutives|max:255',
            'password' => 'required',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $salesexecutives = new Salesexecutives();

        // Handle file upload
        if (isset($request->profile_picture)) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('upload'), $imageName);
            $salesexecutives->profile_picture = $imageName;
        }

        if (isset($request->adhar_card_front_side)) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $salesexecutives->adhar_card_front_side = $imageName;
        }

        if (isset($request->adhar_card_back_side)) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $salesexecutives->adhar_card_back_side = $imageName;
        }

        $salesexecutives->seniorsalesofficer_id = $request->seniorsalesofficer_id;
        $salesexecutives->first_name = $request->first_name;
        $salesexecutives->last_name = $request->last_name;
        $salesexecutives->age = $request->age;
        $salesexecutives->gender = $request->gender;
        $salesexecutives->email = $request->email;
        $salesexecutives->mobile_number = $request->mobile_number;
        $salesexecutives->marital_status = $request->marital_status;
        $salesexecutives->qualification = $request->qualification;
        $salesexecutives->designation = $request->designation;
        $salesexecutives->blood_group = $request->blood_group;
        $salesexecutives->address = $request->address;
        $salesexecutives->country_id = $request->country_id;
        $salesexecutives->state_id = $request->state_id;
        $salesexecutives->city = $request->city;
        $salesexecutives->bio = $request->bio;
        $salesexecutives->pincode = $request->pincode;
        $salesexecutives->username = $request->username;
        $salesexecutives->password = Hash::make($request->password);
        $salesexecutives->status = 'pending';
        $salesexecutives->save();

        $latestEmployee = Employee_ids::orderBy('id', 'desc')->first();

        if (!$latestEmployee) {
            $employee_id = "AMANYA-01";
        } else {
            $recipt_name = $latestEmployee->employee_id;
            $explode_val = explode("-", $recipt_name);
            $exe_value = intval($explode_val[1]) + 1;
            $employee_id = "AMANYA-0" . $exe_value;
        }

        $employee_ids = new Employee_ids();
        $employee_ids->user_type = 'salesexecutives';
        $employee_ids->user_id = $insertedId;
        $employee_ids->employee_id = $employee_id;
        $employee_ids->status = 'enable';
        $employee_ids->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'salesexecutives profile created successfully!',
            'salesexecutives_id' => $salesexecutives->id
        ], 200);
    }

    // Update teamleader
    public function updateSalesexecutive(Request $request)
    {
        // Find the existing Teamleader
        $salesexecutives = Salesexecutives::find($request->id);

        if (!$salesexecutives) {
            return response()->json([
                'status' => false,
                'message' => 'Salesexecutives officer not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'seniorsalesofficer_id' => 'required|exists:seniorsalesofficers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:salesexecutives,email,' . $request->id,
            'mobile_number' => 'required|numeric|unique:salesexecutives,mobile_number,' . $request->id,
            'marital_status' => 'required',
            'qualification' => 'nullable|integer',
            'designation' => 'nullable|integer',
            'blood_group' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'adhar_card_front_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'adhar_card_back_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
            'bio' => 'nullable|string',
            'username' => 'nullable|string|unique:salesexecutives,username,' . $request->id,
            'password' => 'required',
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
        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('upload'), $imageName);
            $salesexecutives->profile_picture = $imageName;
        }

        if ($request->hasFile('adhar_card_front_side')) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $salesexecutives->adhar_card_front_side = $imageName;
        }

        if ($request->hasFile('adhar_card_back_side')) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $salesexecutives->adhar_card_back_side = $imageName;
        }

        // Update fields
        $salesexecutives->seniorsalesofficer_id = $request->get('seniorsalesofficer_id', $salesexecutives->seniorsalesofficer_id);
        $salesexecutives->first_name = $request->get('first_name', $salesexecutives->first_name);
        $salesexecutives->last_name = $request->get('last_name', $salesexecutives->last_name);
        $salesexecutives->age = $request->get('age', $salesexecutives->age);
        $salesexecutives->gender = $request->get('gender', $salesexecutives->gender);
        $salesexecutives->email = $request->get('email', $salesexecutives->email);
        $salesexecutives->mobile_number = $request->get('mobile_number', $salesexecutives->mobile_number);
        $salesexecutives->marital_status = $request->get('marital_status', $salesexecutives->marital_status);
        $salesexecutives->qualification = $request->get('qualification', $salesexecutives->qualification);
        $salesexecutives->designation = $request->get('designation', $salesexecutives->designation);
        $salesexecutives->blood_group = $request->get('blood_group', $salesexecutives->blood_group);
        $salesexecutives->address = $request->get('address', $salesexecutives->address);
        $salesexecutives->country_id = $request->get('country_id', $salesexecutives->country_id);
        $salesexecutives->state_id = $request->get('state_id', $salesexecutives->state_id);
        $salesexecutives->city = $request->get('city', $salesexecutives->city);
        $salesexecutives->bio = $request->get('bio', $salesexecutives->bio);
        $salesexecutives->pincode = $request->get('pincode', $salesexecutives->pincode);
        $salesexecutives->username = $request->get('username', $salesexecutives->username);

        if ($request->has('password')) {
            $salesexecutives->password = Hash::make($request->password);
        }

        $salesexecutives->status = $request->get('status', $salesexecutives->status);
        $salesexecutives->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'salesexecutives profile updated successfully!',
        ], 200);
    }

    // get all salesexecutives
    public function getSalesexecutive()
    {
        $salesexecutives = Salesexecutives::get();
        return response()->json([
            'status' => true,
            'message' => 'All Sales Executives Officer',
            'salesexecutives' => $salesexecutives
        ], 200);
    }

    // get a specific teamleader
    public function getOneSalesexecutive($id)
    {
        $salesexecutives = Salesexecutives::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Salesexecutives details',
            'salesexecutives' => $salesexecutives
        ], 200);
    }

    // delete a teamleader
    public function deleteSalesexecutive($id)
    {
        $Salesexecutives = Salesexecutives::find($id);
        if (!$Salesexecutives) {
            return response()->json([
                'status' => false,
                'message' => 'Salesexecutives not found'
            ], 404);
        }
        $imagePath = public_path('upload') . '/' . $Salesexecutives->profile_picture;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $imagePath2 = public_path('upload') . '/' . $Salesexecutives->adhar_card_front_side;
        if (File::exists($imagePath2)) {
            File::delete($imagePath2);
        }
        $imagePath3 = public_path('upload') . '/' . $Salesexecutives->adhar_card_back_side;
        if (File::exists($imagePath3)) {
            File::delete($imagePath3);
        }
        $Salesexecutives->delete();

        return response()->json([
            'status' => true,
            'message' => 'Salesexecutives deleted successfully'
        ], 200);
    }
}
