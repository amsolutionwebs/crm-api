<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins,Managers,Employee_ids};
use Hash;
use Illuminate\Support\Facades\File;
use Auth;

class ManagerController extends Controller
{
      public function createManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'suparadmin_id' => 'required|exists:suparadmins,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|string',
        'gender' => 'required|in:male,female',
        'email' => 'required|email|unique:managers,email|max:255',
        'mobile_number' => 'required|numeric|unique:managers,mobile_number',
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
        'username' => 'nullable|string|unique:managers|max:255',
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

        $managers = new Managers();

        // Handle file upload
          if (isset($request->profile_picture)) {
                // upload image
        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('upload'), $imageName);
            $managers->profile_picture = $imageName;
        }

          if (isset($request->adhar_card_front_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_front_side->extension();
        $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $managers->adhar_card_front_side = $imageName;
        }

          if (isset($request->adhar_card_back_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_back_side->extension();
        $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $managers->adhar_card_back_side = $imageName;
        }

        $managers->suparadmin_id = $request->suparadmin_id;
        $managers->first_name = $request->first_name;
        $managers->last_name = $request->last_name;
        $managers->age = $request->age;
        $managers->gender = $request->gender;
        $managers->email = $request->email;
        $managers->mobile_number = $request->mobile_number;
        $managers->marital_status = $request->marital_status;
        $managers->qualification = $request->qualification;
        $managers->designation = $request->designation;
        $managers->blood_group = $request->blood_group;
        $managers->address = $request->address;
        $managers->country_id = $request->country_id;
        $managers->state_id = $request->state_id;
        $managers->city = $request->city;
        $managers->bio = $request->bio;
        $managers->pincode = $request->pincode;
        $managers->username = $request->username;
        $managers->password = Hash::make($request->password);
        $managers->status = 'pending';
        $managers->save();
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
        $employee_ids->user_type = 'managers';
        $employee_ids->user_id = $managers->id;
        $employee_ids->employee_id = $employee_id;
        $employee_ids->status = 'enable';
        $employee_ids->save();

        return response()->json([
            'status' => true,
            'message' => 'managers profile created successfully!',
            'managers_id' => $managers->id
        ], 200);

    }


    // update supar admin

    public function updateManager(Request $request)
    {
        // Find the existing managers
        $managers = Managers::find($request->id);

        if (!$managers) {
            return response()->json([
                'status' => false,
                'message' => 'managers not found',
            ], 404);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
        'id' => 'required',
        'suparadmin_id' => 'required|exists:suparadmins,id',
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
            $managers->profile_picture = $imageName;
        }

        if ($request->hasFile('adhar_card_front_side')) {
            $imageName = time() . '.' . $request->adhar_card_front_side->extension();
            $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $managers->adhar_card_front_side = $imageName;
        }

        if ($request->hasFile('adhar_card_back_side')) {
            $imageName = time() . '.' . $request->adhar_card_back_side->extension();
            $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $managers->adhar_card_back_side = $imageName;
        }

        // Update fields
        $managers->suparadmin_id = $request->get('suparadmin_id', $managers->suparadmin_id);
        $managers->first_name = $request->get('first_name', $managers->first_name);
        $managers->last_name = $request->get('last_name', $managers->last_name);
        $managers->age = $request->get('age', $managers->age);
        $managers->gender = $request->get('gender', $managers->gender);
        $managers->email = $request->get('email', $managers->email);
        $managers->mobile_number = $request->get('mobile_number', $managers->mobile_number);
        $managers->marital_status = $request->get('marital_status', $managers->marital_status);
        $managers->qualification = $request->get('qualification', $managers->qualification);
        $managers->designation = $request->get('designation', $managers->designation);
        $managers->blood_group = $request->get('blood_group', $managers->blood_group);
        $managers->address = $request->get('address', $managers->address);
        $managers->country_id = $request->get('country_id', $managers->country_id);
        $managers->state_id = $request->get('state_id', $managers->state_id);
        $managers->city = $request->get('city', $managers->city);
        $managers->bio = $request->get('bio', $managers->bio);
        $managers->pincode = $request->get('pincode', $managers->pincode);
        $managers->username = $request->get('username', $managers->username);

        if ($request->has('password')) {
            $managers->password = Hash::make($request->password);
        }

        $managers->status = $request->get('status', $managers->status);
        $managers->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'managers profile updated successfully!',
        ], 200);
    }


    // get all supar admin

    public function getManager()
    {
        $managers = Managers::get();
        return response()->json([
        'status' => true,
        'message' => 'All Supar Admin',
        'managers' => $managers
    ], 200);
    }

    // get all supar admin

    public function getmanagersOne($id)
    {
        $managers = Managers::where('id',$id)->first();
            return response()->json([
            'status' => true,
            'message' => 'Manager details',
            'managers' => $managers
        ], 200);
    }

    // delete supar admin
    public function deleteManager($id)
    {

        $managerss = Managers::find($id);
        if (!$managerss) {
            return response()->json([
                'status' => false,
                'message' => 'managerss not found'
            ], 404);
        }
        $imagePath = public_path('upload') . '/' . $managerss->profile_picture;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $imagePath2 = public_path('upload') . '/' . $managerss->adhar_card_front_side;
        if (File::exists($imagePath2)) {
            File::delete($imagePath2);
        }
        $imagePath3 = public_path('upload') . '/' . $managerss->adhar_card_back_side;
        if (File::exists($imagePath3)) {
            File::delete($imagePath3);
        }
        $managerss->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'manager deleted successfully'
        ], 200);
    }
}
