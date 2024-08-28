<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Suparadmins, Managers, Teamleaders, Seniorsalesofficers};
use Hash;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class UploadExcelByManagerController extends Controller
{
    public function uploadExcelByManager(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'manager_id' => 'required|exists:managers,id',
            'excel_file' => 'required|file|mimes:xlsx,xls',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $manager_id = $request->input('manager_id');
        
        Excel::import(new ManagerImports($manager_id), $request->file('excel_file'));

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Excel file uploaded successfully!',
           
        ], 200);
    }
}
