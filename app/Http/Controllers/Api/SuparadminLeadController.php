<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\SuparadminImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Seniorsalesofficers};
use Hash;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class SuparadminLeadController extends Controller
{
    public function uploadExcelBySuparadmin(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'suparadmin_id' => 'required|exists:suparadmins,id',
            'excel_file' => 'required|file|mimes:xlsx,xls',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $suparadmin_id = $request->input('suparadmin_id');
        
        Excel::import(new SuparadminImport($suparadmin_id), $request->file('excel_file'));

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Excel file uploaded successfully!',
           
        ], 200);
    }
}
