<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Seniorsalesofficers, Salesexecutives};
use Illuminate\Support\Facades\File;
use Hash;
use Auth;


class ApploginController extends Controller
{
    public function appLogin(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
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

        // if user type suparadmin 1 
        if($request->user_type==1)
        {
                if (Auth::guard('suparadmins')->attempt($credentials)) {
                // Authentication passed
                $suparadmin = Auth::guard('suparadmins')->user(); // Retrieve authenticated admin

                // Generate a token with Sanctum
                $token = $suparadmin->createToken('API_TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Supar Admin logged in successfully!',
                    'suparadmin' => $suparadmin,
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

        // if user type 2 
        if($request->user_type==2)
        {
             if (Auth::guard('managers')->attempt($credentials)) 
             {
                // Authentication passed
                $managers = Auth::guard('managers')->user(); // Retrieve authenticated admin

                // Generate a token with Sanctum
                $token = $managers->createToken('API_TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Managers logged in successfully!',
                    'managers' => $managers,
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized managers',
                ], 401);
            }
        }

        // if user type 3 
        if($request->user_type==3)
        {
             if (Auth::guard('teamleaders')->attempt($credentials)) {
                // Authentication passed
                $teamleaders = Auth::guard('teamleaders')->user(); // Retrieve authenticated admin

                // Generate a token with Sanctum
                $token = $teamleaders->createToken('API_TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Teamleaders logged in successfully!',
                    'teamleaders' => $teamleaders,
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized teamleaders',
                ], 401);
            }
        }

        // if user type 4 
        if($request->user_type==4)
        {
             if (Auth::guard('seniorsalesofficers')->attempt($credentials)) {
                // Authentication passed
                $seniorsalesofficers = Auth::guard('seniorsalesofficers')->user(); // Retrieve authenticated admin

                // Generate a token with Sanctum
                $token = $seniorsalesofficers->createToken('API_TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Senior sales officers logged in successfully!',
                    'seniorsalesofficers' => $seniorsalesofficers,
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized seniorsalesofficers',
                ], 401);
            }
        }

        // if user type 5 
        if($request->user_type==5)
        {
             if (Auth::guard('salesexecutives')->attempt($credentials)) {
                // Authentication passed
                $salesexecutives = Auth::guard('salesexecutives')->user(); // Retrieve authenticated admin

                // Generate a token with Sanctum
                $token = $salesexecutives->createToken('API_TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Sales executives logged in successfully!',
                    'salesexecutives' => $salesexecutives,
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized Sales executives',
                ], 401);
            }
        }

    }
}
