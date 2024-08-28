<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Admins,Customers};
use Hash;
use file;
use Auth;

class CustomerController extends Controller
{
     public function createCustomer(Request $request)
    {
          $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'additional_info' => 'required|string',
        'contact_details' => 'required|unique:customers',
        'contact_two' => 'nullable',
        'email' => 'nullable',
        'website' => 'nullable',
        'address' => 'nullable|string|max:255',
        'additional_address' => 'nullable',
        'tag_id' => 'nullable',
        'status' => 'nullable'
    ]);


    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

        $customer = new Customers();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->additional_info = $request->additional_info;
        $customer->contact_details = $request->contact_details;
        $customer->contact_two = $request->contact_two;
        $customer->email = $request->email;
        $customer->website = $request->website;
        $customer->address = $request->address;
        $customer->additional_address = $request->additional_address;
        $customer->tag_id = $request->tag_id;
        $customer->status = $request->status;
        $customer->save();
         // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Customer profile created successfully!'
    ], 200);

    }
    
    

     public function updateCustomer(Request $request)
    {
          $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'additional_info' => 'required|string',
        'contact_details' => 'required',
        'contact_two' => 'nullable',
        'email' => 'nullable',
        'website' => 'nullable',
        'address' => 'nullable|string|max:255',
        'additional_address' => 'nullable',
        'tag_id' => 'nullable',
        'status' => 'nullable'
    ]);


    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

       $customer = Customers::where('id',$request->id)->first();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->additional_info = $request->additional_info;
        $customer->contact_details = $request->contact_details;
        $customer->contact_two = $request->contact_two;
        $customer->email = $request->email;
        $customer->website = $request->website;
        $customer->address = $request->address;
        $customer->additional_address = $request->additional_address;
        $customer->tag_id = $request->tag_id;
        $customer->status = $request->status;
        $customer->save();
         // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Customer profile updated successfully!'
    ], 200);

    }


    public function getCustomer()
    {
         $customer = Customers::get();
         
         return response()->json([
        'status' => true,
        'message' => 'All Customer',
        'customer' => $customer
    ], 200);
    }



    public function deleteCustomer($id)
    {

        $customer = Customers::where('id',$id)->first();
        $customer->delete();

         return response()->json([
        'status' => true,
        'message' => 'Customer details successfully remove'
    ], 200);


    }






}
