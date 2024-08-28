<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Seniorsalesofficers, Employee_ids};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class SeniorSalesOfficerController extends Controller
{
    public function createSeniorsalesofficer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teamleader_id' => 'required|exists:teamleaders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:seniorsalesofficers,email|max:255',
            'mobile_number' => 'required|numeric|unique:seniorsalesofficers,mobile_number',
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
            'username' => 'nullable|string|unique:seniorsalesofficers|max:255',
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

        $Seniorsalesofficer = new Seniorsalesofficers();

        // Handle file upload
        if (isset($request->profile_picture)) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('upload'), $imageName);
            $Seniorsalesofficer->profile_picture = $imageName;
        }

        if (isset($request->adhar_card_front_side)) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $Seniorsalesofficer->adhar_card_front_side = $imageName;
        }

        if (isset($request->adhar_card_back_side)) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $Seniorsalesofficer->adhar_card_back_side = $imageName;
        }

        $Seniorsalesofficer->teamleader_id = $request->teamleader_id;
        $Seniorsalesofficer->first_name = $request->first_name;
        $Seniorsalesofficer->last_name = $request->last_name;
        $Seniorsalesofficer->age = $request->age;
        $Seniorsalesofficer->gender = $request->gender;
        $Seniorsalesofficer->email = $request->email;
        $Seniorsalesofficer->mobile_number = $request->mobile_number;
        $Seniorsalesofficer->marital_status = $request->marital_status;
        $Seniorsalesofficer->qualification = $request->qualification;
        $Seniorsalesofficer->designation = $request->designation;
        $Seniorsalesofficer->blood_group = $request->blood_group;
        $Seniorsalesofficer->address = $request->address;
        $Seniorsalesofficer->country_id = $request->country_id;
        $Seniorsalesofficer->state_id = $request->state_id;
        $Seniorsalesofficer->city = $request->city;
        $Seniorsalesofficer->bio = $request->bio;
        $Seniorsalesofficer->pincode = $request->pincode;
        $Seniorsalesofficer->username = $request->username;
        $Seniorsalesofficer->password = Hash::make($request->password);
        $Seniorsalesofficer->status = 'pending';
        $Seniorsalesofficer->save();

        $latestEmployee = Employee_ids::orderBy('id', 'desc')->first();

        if (!$latestEmployee) {
            $employee_id = "AMANYA-01";
        } else {
            $recipt_name = $Seniorsalesofficer->id;
            $explode_val = explode("-", $recipt_name);
            $exe_value = intval($explode_val[1]) + 1;
            $employee_id = "AMANYA-0" . $exe_value;
        }

        $employee_ids = new Employee_ids();
        $employee_ids->user_type = 'seniorsalesofficers';
        $employee_ids->user_id = $insertedId;
        $employee_ids->employee_id = $employee_id;
        $employee_ids->status = 'enable';
        $employee_ids->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Seniorsalesofficer profile created successfully!',
            'Seniorsalesofficer_id' => $Seniorsalesofficer->id
        ], 200);
    }

    // Update teamleader
    public function updateSeniorsalesofficer(Request $request)
    {
        // Find the existing Teamleader
        $Seniorsalesofficer = Seniorsalesofficers::find($request->id);

        if (!$Seniorsalesofficer) {
            return response()->json([
                'status' => false,
                'message' => 'Senior sales officer not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'teamleader_id' => 'required|exists:teamleaders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:seniorsalesofficers,email,' . $request->id,
            'mobile_number' => 'required|numeric|unique:seniorsalesofficers,mobile_number,' . $request->id,
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
            'username' => 'nullable|string|unique:seniorsalesofficers,username,' . $request->id,
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
            $Seniorsalesofficer->profile_picture = $imageName;
        }

        if ($request->hasFile('adhar_card_front_side')) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $Seniorsalesofficer->adhar_card_front_side = $imageName;
        }

        if ($request->hasFile('adhar_card_back_side')) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $Seniorsalesofficer->adhar_card_back_side = $imageName;
        }

        // Update fields
        $Seniorsalesofficer->teamleader_id = $request->get('teamleader_id', $Seniorsalesofficer->teamleader_id);
        $Seniorsalesofficer->first_name = $request->get('first_name', $Seniorsalesofficer->first_name);
        $Seniorsalesofficer->last_name = $request->get('last_name', $Seniorsalesofficer->last_name);
        $Seniorsalesofficer->age = $request->get('age', $Seniorsalesofficer->age);
        $Seniorsalesofficer->gender = $request->get('gender', $Seniorsalesofficer->gender);
        $Seniorsalesofficer->email = $request->get('email', $Seniorsalesofficer->email);
        $Seniorsalesofficer->mobile_number = $request->get('mobile_number', $Seniorsalesofficer->mobile_number);
        $Seniorsalesofficer->marital_status = $request->get('marital_status', $Seniorsalesofficer->marital_status);
        $Seniorsalesofficer->qualification = $request->get('qualification', $Seniorsalesofficer->qualification);
        $Seniorsalesofficer->designation = $request->get('designation', $Seniorsalesofficer->designation);
        $Seniorsalesofficer->blood_group = $request->get('blood_group', $Seniorsalesofficer->blood_group);
        $Seniorsalesofficer->address = $request->get('address', $Seniorsalesofficer->address);
        $Seniorsalesofficer->country_id = $request->get('country_id', $Seniorsalesofficer->country_id);
        $Seniorsalesofficer->state_id = $request->get('state_id', $Seniorsalesofficer->state_id);
        $Seniorsalesofficer->city = $request->get('city', $Seniorsalesofficer->city);
        $Seniorsalesofficer->bio = $request->get('bio', $Seniorsalesofficer->bio);
        $Seniorsalesofficer->pincode = $request->get('pincode', $Seniorsalesofficer->pincode);
        $Seniorsalesofficer->username = $request->get('username', $Seniorsalesofficer->username);

        if ($request->has('password')) {
            $Seniorsalesofficer->password = Hash::make($request->password);
        }

        $Seniorsalesofficer->status = $request->get('status', $Seniorsalesofficer->status);
        $Seniorsalesofficer->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Seniorsalesofficer profile updated successfully!',
        ], 200);
    }

    // get all Seniorsalesofficer
    public function getSeniorsalesofficer()
    {
        $Seniorsalesofficer = Seniorsalesofficers::get();
        return response()->json([
            'status' => true,
            'message' => 'All Seniorsalesofficer',
            'Seniorsalesofficer' => $Seniorsalesofficer
        ], 200);
    }

    // get a specific teamleader
    public function getOneSeniorsalesofficer($id)
    {
        $Seniorsalesofficer = Seniorsalesofficers::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Teamleader details',
            'Seniorsalesofficer' => $Seniorsalesofficer
        ], 200);
    }

    // delete a teamleader
    public function deleteSeniorsalesofficer($id)
    {
        $Seniorsalesofficers = Seniorsalesofficers::find($id);
        if (!$Seniorsalesofficers) {
            return response()->json([
                'status' => false,
                'message' => 'Seniorsalesofficer not found'
            ], 404);
        }
        $imagePath = public_path('upload') . '/' . $Seniorsalesofficers->profile_picture;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $imagePath2 = public_path('upload') . '/' . $Seniorsalesofficers->adhar_card_front_side;
        if (File::exists($imagePath2)) {
            File::delete($imagePath2);
        }
        $imagePath3 = public_path('upload') . '/' . $Seniorsalesofficers->adhar_card_back_side;
        if (File::exists($imagePath3)) {
            File::delete($imagePath3);
        }
        $Seniorsalesofficers->delete();

        return response()->json([
            'status' => true,
            'message' => 'Seniorsalesofficer deleted successfully'
        ], 200);
    }
}
