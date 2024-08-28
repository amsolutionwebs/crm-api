<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Admins};
use Hash;
use file;
use Auth;

class AdminController extends Controller
{
    public function checkApi(){
        echo "API server is working";
    }
    
    public function getEmployee()
    {
         $admin = Admins::get();
         
         return response()->json([
        'status' => true,
        'message' => 'All Employees',
        'admin' => $admin
    ], 200);
    }
    
    
    public function adminSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|string',
        'gender' => 'required|in:male,female',
        'employee_id' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email|max:255',
        'mobile_number' => 'required|numeric|unique:admins,mobile_number',
        'marital_status' => 'required',
        'qualification' => 'nullable|integer',
        'designation' => 'nullable|integer',
        'blood_group' => 'nullable|integer',
        'address' => 'nullable|string|max:255',
        'country' => 'nullable|integer',
        'state' => 'nullable|integer',
        'city' => 'nullable|string|max:255',
        'pincode' => 'nullable|string|max:20',
        'profile_picture' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
        'adhar_card_front_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
        'adhar_card_back_side' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,webp',
        'bio' => 'nullable|string',
        'username' => 'nullable|string|unique:admins|max:255',
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

        $admin = new Admins();

        // Handle file upload
          if (isset($request->profile_picture)) {
                // upload image
        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('upload'), $imageName);
            $admin->profile_picture = $imageName;
        }

          if (isset($request->adhar_card_front_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_front_side->extension();
        $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $admin->adhar_card_front_side = $imageName;
        }

          if (isset($request->adhar_card_back_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_back_side->extension();
        $request->adhar_card_back_side->move(public_path('upload'), $imageName);
            $admin->adhar_card_back_side = $imageName;
        }

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->age = $request->age;
        $admin->gender = $request->gender;
        $admin->employee_id = $request->employee_id;
        $admin->email = $request->email;
        $admin->mobile_number = $request->mobile_number;
        $admin->marital_status = $request->marital_status;
        $admin->qualification = $request->qualification;
        $admin->designation = $request->designation;
        $admin->blood_group = $request->blood_group;
        $admin->address = $request->address;
        $admin->country = $request->country;
        $admin->state = $request->state;
        $admin->city = $request->city;
        $admin->bio = $request->bio;
        $admin->pincode = $request->pincode;
        $admin->username = $request->username;
        $admin->password = Hash::make($request->password);
        $admin->status = 'pending';
        $admin->save();
         // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Admin profile created successfully!',
            'admin_id' => $admin->id
        ], 200);

    }


    // admin login
    public function adminLogin(Request $request){
        
         $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

     $credentials = $request->only('username', 'password');

     if (Auth::guard('admins')->attempt($credentials)) {
        // Authentication passed
        $admin = Auth::guard('admins')->user(); // Retrieve authenticated admin

        // Generate a token with Sanctum
        $token = $admin->createToken('API_TOKEN')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Admin logged in successfully!',
            'admin' => $admin,
            'access_token' => $token,
            'token_type' => 'bearer'
        ], 200);
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    }
}
