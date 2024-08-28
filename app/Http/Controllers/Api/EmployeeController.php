<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Admins,Employees};
use Hash;
use file;
use Auth;

class EmployeeController extends Controller
{
     public function employeeSignup(Request $request)
    {
          $validator = Validator::make($request->all(), [
        'admin_id' => 'required|exists:admins,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|string',
        'gender' => 'required|in:male,female',
        'employee_id' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email|max:255',
        'mobile_number' => 'required|numeric|unique:employees,mobile_number',
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
        'username' => 'nullable|string|unique:employees|max:255',
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

      $employee = new Employees();

    // Handle file upload
          if (isset($request->profile_picture)) {
                // upload image
        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('upload'), $imageName);
            $employee->profile_picture = $imageName;
        }

          if (isset($request->adhar_card_front_side)) {
                // upload image
        $imageName = time() . '.' . $request->adhar_card_front_side->extension();
        $request->adhar_card_front_side->move(public_path('upload'), $imageName);
            $employee->adhar_card_front_side = $imageName;
        }

        if (isset($request->adhar_card_back_side)) {
    // upload image
    $imageName = time() . '.' . $request->adhar_card_back_side->extension();
    $request->adhar_card_back_side->move(public_path('upload'), $imageName);
    $employee->adhar_card_back_side = $imageName;
}



        $employee->admin_id = $request->admin_id;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->age = $request->age;
        $employee->gender = $request->gender;
        $employee->employee_id = $request->employee_id;
        $employee->email = $request->email;
        $employee->mobile_number = $request->mobile_number;
        $employee->marital_status = $request->marital_status;
        $employee->qualification = $request->qualification;
        $employee->designation = $request->designation;
        $employee->blood_group = $request->blood_group;
        $employee->address = $request->address;
        $employee->country = $request->country;
        $employee->state = $request->state;
        $employee->city = $request->city;
        $employee->bio = $request->bio;
        $employee->pincode = $request->pincode;
        $employee->username = $request->username;
        $employee->password = Hash::make($request->password);
        $employee->status = 'pending';
        $employee->save();
         // Return success response
    return response()->json([
        'status' => true,
        'message' => 'employee profile created successfully!',
        'employee_id' => $employee->id
    ], 200);

    }
    
    
    public function getAllEmployee()
    {
         $admin = Employees::get();
         
         return response()->json([
        'status' => true,
        'message' => 'All Employees',
        'admin' => $admin
    ], 200);
    }
}
