<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Employee_ids};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class TeamLeaderController extends Controller
{
    public function createTeamleader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'manager_id' => 'required|exists:managers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:teamleaders,email|max:255',
            'mobile_number' => 'required|numeric|unique:teamleaders,mobile_number',
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
            'username' => 'nullable|string|unique:teamleaders|max:255',
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

        $Teamleaders = new Teamleaders();

        // Handle file upload
        if (isset($request->profile_picture)) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('upload'), $imageName);
            $Teamleaders->profile_picture = $imageName;
        }

        if (isset($request->adhar_card_front_side)) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $Teamleaders->adhar_card_front_side = $imageName;
        }

        if (isset($request->adhar_card_back_side)) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $Teamleaders->adhar_card_back_side = $imageName;
        }

        $Teamleaders->manager_id = $request->manager_id;
        $Teamleaders->first_name = $request->first_name;
        $Teamleaders->last_name = $request->last_name;
        $Teamleaders->age = $request->age;
        $Teamleaders->gender = $request->gender;
        $Teamleaders->email = $request->email;
        $Teamleaders->mobile_number = $request->mobile_number;
        $Teamleaders->marital_status = $request->marital_status;
        $Teamleaders->qualification = $request->qualification;
        $Teamleaders->designation = $request->designation;
        $Teamleaders->blood_group = $request->blood_group;
        $Teamleaders->address = $request->address;
        $Teamleaders->country_id = $request->country_id;
        $Teamleaders->state_id = $request->state_id;
        $Teamleaders->city = $request->city;
        $Teamleaders->bio = $request->bio;
        $Teamleaders->pincode = $request->pincode;
        $Teamleaders->username = $request->username;
        $Teamleaders->password = Hash::make($request->password);
        $Teamleaders->status = 'pending';
        $Teamleaders->save();


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
        $employee_ids->user_type = 'suparadmins';
        $employee_ids->user_id = $Teamleaders->id;
        $employee_ids->employee_id = $employee_id;
        $employee_ids->status = 'enable';
        $employee_ids->save();


        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Teamleaders profile created successfully!',
            'Teamleaders_id' => $Teamleaders->id
        ], 200);
    }

    // Update teamleader
    public function updateTeamleader(Request $request)
    {
        // Find the existing Teamleader
        $Teamleader = Teamleaders::find($request->id);

        if (!$Teamleader) {
            return response()->json([
                'status' => false,
                'message' => 'Teamleader not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'manager_id' => 'required|exists:managers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:teamleaders,email,' . $request->id,
            'mobile_number' => 'required|numeric|unique:teamleaders,mobile_number,' . $request->id,
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
            'username' => 'nullable|string|unique:teamleaders,username,' . $request->id,
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
            $Teamleader->profile_picture = $imageName;
        }

        if ($request->hasFile('adhar_card_front_side')) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $Teamleader->adhar_card_front_side = $imageName;
        }

        if ($request->hasFile('adhar_card_back_side')) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $Teamleader->adhar_card_back_side = $imageName;
        }

        // Update fields
        $Teamleader->manager_id = $request->get('manager_id', $Teamleader->manager_id);
        $Teamleader->first_name = $request->get('first_name', $Teamleader->first_name);
        $Teamleader->last_name = $request->get('last_name', $Teamleader->last_name);
        $Teamleader->age = $request->get('age', $Teamleader->age);
        $Teamleader->gender = $request->get('gender', $Teamleader->gender);
        $Teamleader->email = $request->get('email', $Teamleader->email);
        $Teamleader->mobile_number = $request->get('mobile_number', $Teamleader->mobile_number);
        $Teamleader->marital_status = $request->get('marital_status', $Teamleader->marital_status);
        $Teamleader->qualification = $request->get('qualification', $Teamleader->qualification);
        $Teamleader->designation = $request->get('designation', $Teamleader->designation);
        $Teamleader->blood_group = $request->get('blood_group', $Teamleader->blood_group);
        $Teamleader->address = $request->get('address', $Teamleader->address);
        $Teamleader->country_id = $request->get('country_id', $Teamleader->country_id);
        $Teamleader->state_id = $request->get('state_id', $Teamleader->state_id);
        $Teamleader->city = $request->get('city', $Teamleader->city);
        $Teamleader->bio = $request->get('bio', $Teamleader->bio);
        $Teamleader->pincode = $request->get('pincode', $Teamleader->pincode);
        $Teamleader->username = $request->get('username', $Teamleader->username);

        if ($request->has('password')) {
            $Teamleader->password = Hash::make($request->password);
        }

        $Teamleader->status = $request->get('status', $Teamleader->status);
        $Teamleader->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Teamleader profile updated successfully!',
        ], 200);
    }

    // get all teamleaders
    public function getTeamleader()
    {
        $Teamleaders = Teamleaders::get();
        return response()->json([
            'status' => true,
            'message' => 'All Teamleaders',
            'Teamleaders' => $Teamleaders
        ], 200);
    }

    // get a specific teamleader
    public function getTeamleaderOne($id)
    {
        $Teamleaders = Teamleaders::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Teamleader details',
            'Teamleaders' => $Teamleaders
        ], 200);
    }

    // delete a teamleader
    public function deleteTeamleader($id)
    {
        $Teamleaderss = Teamleaders::find($id);
        if (!$Teamleaderss) {
            return response()->json([
                'status' => false,
                'message' => 'Teamleader not found'
            ], 404);
        }
        $imagePath = public_path('upload') . '/' . $Teamleaderss->profile_picture;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $imagePath2 = public_path('upload') . '/' . $Teamleaderss->adhar_card_front_side;
        if (File::exists($imagePath2)) {
            File::delete($imagePath2);
        }
        $imagePath3 = public_path('upload') . '/' . $Teamleaderss->adhar_card_back_side;
        if (File::exists($imagePath3)) {
            File::delete($imagePath3);
        }
        $Teamleaderss->delete();

        return response()->json([
            'status' => true,
            'message' => 'Teamleader deleted successfully'
        ], 200);
    }
}
