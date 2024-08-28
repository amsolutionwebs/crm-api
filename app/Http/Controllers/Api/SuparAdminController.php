<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins,Employee_ids};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class SuparAdminController extends Controller
{
     public function createSuparadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|string',
        'gender' => 'required|in:male,female',
        'email' => 'required|email|unique:suparadmins,email|max:255',
        'mobile_number' => 'required|numeric|unique:suparadmins,mobile_number',
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
        'username' => 'nullable|string|unique:suparadmins|max:255',
        'password' => 'required',
        'status' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // get emp id

         

        

        // end emp id
        $suparadmin = new Suparadmins();

        // Handle file upload
          if (isset($request->profile_picture)) {
                // upload image
        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('upload'), $imageName);
            $suparadmin->profile_picture = $imageName;
        }

          if (isset($request->adhar_card_front_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_front_side->extension();
        $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $suparadmin->adhar_card_front_side = $imageName;
        }

          if (isset($request->adhar_card_back_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_back_side->extension();
        $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $suparadmin->adhar_card_back_side = $imageName;
        }

        $suparadmin->employee_id = $employee_id;
        $suparadmin->first_name = $request->first_name;
        $suparadmin->last_name = $request->last_name;
        $suparadmin->age = $request->age;
        $suparadmin->gender = $request->gender;
        $suparadmin->email = $request->email;
        $suparadmin->mobile_number = $request->mobile_number;
        $suparadmin->marital_status = $request->marital_status;
        $suparadmin->qualification = $request->qualification;
        $suparadmin->designation = $request->designation;
        $suparadmin->blood_group = $request->blood_group;
        $suparadmin->address = $request->address;
        $suparadmin->country_id = $request->country_id;
        $suparadmin->state_id = $request->state_id;
        $suparadmin->city = $request->city;
        $suparadmin->bio = $request->bio;
        $suparadmin->pincode = $request->pincode;
        $suparadmin->username = $request->username;
        $suparadmin->password = Hash::make($request->password);
        $suparadmin->status = 'pending';
        $suparadmin->save();
        $insertedId = $suparadmin->id;
         // Return success response

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
        $employee_ids->user_id = $insertedId;
        $employee_ids->employee_id = $employee_id;
        $employee_ids->status = 'enable';
        $employee_ids->save();
       
        // end employee id
        return response()->json([
            'status' => true,
            'message' => 'Suparadmin profile created successfully!',
            'suparadmin_id' => $suparadmin->id
        ], 200);

    }


    // update supar admin

    public function updateSuparadmin(Request $request)
    {
        // Find the existing Suparadmin
        $suparadmin = Suparadmins::find($request->id);

        if (!$suparadmin) {
            return response()->json([
                'status' => false,
                'message' => 'Suparadmin not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|string',
        'gender' => 'required|in:male,female',
        'email' => 'required|email',
        'mobile_number' => 'required|numeric',
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
        'username' => 'nullable|string',
        'password' => 'required',
        'status' => 'nullable'
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
            $suparadmin->profile_picture = $imageName;
        }

        if ($request->hasFile('adhar_card_front_side')) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $suparadmin->adhar_card_front_side = $imageName;
        }

        if ($request->hasFile('adhar_card_back_side')) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $suparadmin->adhar_card_back_side = $imageName;
        }

        // Update fields
        $suparadmin->first_name = $request->get('first_name', $suparadmin->first_name);
        $suparadmin->last_name = $request->get('last_name', $suparadmin->last_name);
        $suparadmin->age = $request->get('age', $suparadmin->age);
        $suparadmin->gender = $request->get('gender', $suparadmin->gender);
        $suparadmin->email = $request->get('email', $suparadmin->email);
        $suparadmin->mobile_number = $request->get('mobile_number', $suparadmin->mobile_number);
        $suparadmin->marital_status = $request->get('marital_status', $suparadmin->marital_status);
        $suparadmin->qualification = $request->get('qualification', $suparadmin->qualification);
        $suparadmin->designation = $request->get('designation', $suparadmin->designation);
        $suparadmin->blood_group = $request->get('blood_group', $suparadmin->blood_group);
        $suparadmin->address = $request->get('address', $suparadmin->address);
        $suparadmin->country_id = $request->get('country_id', $suparadmin->country_id);
        $suparadmin->state_id = $request->get('state_id', $suparadmin->state_id);
        $suparadmin->city = $request->get('city', $suparadmin->city);
        $suparadmin->bio = $request->get('bio', $suparadmin->bio);
        $suparadmin->pincode = $request->get('pincode', $suparadmin->pincode);
        $suparadmin->username = $request->get('username', $suparadmin->username);

        if ($request->has('password')) {
            $suparadmin->password = Hash::make($request->password);
        }

        $suparadmin->status = $request->get('status', $suparadmin->status);
        $suparadmin->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Suparadmin profile updated successfully!',
        ], 200);
    }


    // get all supar admin

    public function getSuparadminAll()
    {
        $suparadmins = Suparadmins::get();
        return response()->json([
        'status' => true,
        'message' => 'All Supar Admin',
        'suparadmins' => $suparadmins
    ], 200);
    }

    // get all supar admin

    public function getSuparadminOne($id)
    {
        $suparadmins = Suparadmins::where('id',$id)->first();
            return response()->json([
            'status' => true,
            'message' => 'Supar admin details',
            'suparadmins' => $suparadmins
        ], 200);
    }

    // delete supar admin
    public function deleteSuparadmin(Request $request, $id)
    {

        $suparadmins = Suparadmins::find($id);
        if (!$suparadmins) {
            return response()->json([
                'status' => false,
                'message' => 'Suparadmins not found'
            ], 404);
        }
        $imagePath = public_path('upload') . '/' . $suparadmins->profile_picture;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $imagePath2 = public_path('upload') . '/' . $suparadmins->adhar_card_front_side;
        if (File::exists($imagePath2)) {
            File::delete($imagePath2);
        }
        $imagePath3 = public_path('upload') . '/' . $suparadmins->adhar_card_back_side;
        if (File::exists($imagePath3)) {
            File::delete($imagePath3);
        }
        $suparadmins->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Suparadmins deleted successfully'
        ], 200);
    }


}
