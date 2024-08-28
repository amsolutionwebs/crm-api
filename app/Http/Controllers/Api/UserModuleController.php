<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usermodules;

class UserModuleController extends Controller
{
     public function createUsermodules(Request $request)
   {
        try {
            $validated = $request->validate([
                'employee_id' => 'required|integer',
                'modules' => 'required|array',
                'modules.*.module_id' => 'required|integer',
                'modules.*.add' => 'required|string',
                'modules.*.view' => 'required|string',
                'modules.*.edit' => 'required|string',
                'modules.*.delete' => 'required|string',
                'modules.*.status' => 'required|string',
            ]);

            foreach ($validated['modules'] as $module) {
                Usermodules::create([
                    'employee_id' => $validated['employee_id'],
                    'module_id' => $module['module_id'],
                    'add' => $module['add'],
                    'view' => $module['view'],
                    'edit' => $module['edit'],
                    'delete' => $module['delete'],
                    'status' => $module['status'],
                ]);
            }

            return response()->json(['status' => true, 'message' => 'Modules added successfully'], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Update teamleader
    public function updateUsermodules(Request $request, $id)
    {
        $validated = $request->validate([
            'modules' => 'required|array',
            'modules.*.module_id' => 'required|integer',
            'modules.*.add' => 'required|string',
            'modules.*.view' => 'required|string',
            'modules.*.edit' => 'required|string',
            'modules.*.delete' => 'required|string',
            'modules.*.status' => 'required|string',
        ]);

        foreach ($validated['modules'] as $module) {
            $employeeModule = Usermodules::where('employee_id', $id)
                ->where('module_id', $module['module_id'])
                ->first();

            if ($employeeModule) {
                $employeeModule->update([
                    'add' => $module['add'],
                    'view' => $module['view'],
                    'edit' => $module['edit'],
                    'delete' => $module['delete'],
                    'status' => $module['status'],
                ]);
            } else {
                Usermodules::create([
                    'employee_id' => $id,
                    'module_id' => $module['module_id'],
                    'add' => $module['add'],
                    'view' => $module['view'],
                    'edit' => $module['edit'],
                    'delete' => $module['delete'],
                    'status' => $module['status'],
                ]);
            }
        }

        return response()->json(['message' => 'Modules updated successfully'], 200);
    
    }

    // get all salesexecutives
    public function getUsermodules($id)
    {
        $Usermodules = Usermodules::where('employee_id',$id)->get();
        return response()->json([
            'status' => true,
            'message' => 'All Usermodules',
            'Usermodules' => $Usermodules
        ], 200);
    }

    // get a specific teamleader
    public function getAlreadyUsermodules($employee_id,$module_id)
    {
        $Usermodules = Usermodules::where('employee_id',$employee_id)->where('module_id',$module_id)->first();
        if($Usermodules){
             return response()->json([
            'status' => false,
            'message' => 'Usermodules details',
            'Usermodules' => 'found'
        ], 200);
        }else{
            return response()->json([
            'status' => true,
            'message' => 'Usermodules details',
            'Usermodules' => 'not_found'
        ], 200);
        }
        
        
    }

    // delete a teamleader
    public function deleteUsermodules($id)
    {
        $Usermodules = Usermodules::find($id);
        if (!$Usermodules) {
            return response()->json([
                'status' => false,
                'message' => 'Usermodules not found'
            ], 404);
        }
       
        $Usermodules->delete();

        return response()->json([
            'status' => true,
            'message' => 'Usermodules deleted successfully'
        ], 200);
    }
}
