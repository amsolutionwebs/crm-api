<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Modules;

class ModuleController extends Controller
{
     public function createModules(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_name' => 'required',
            'module_short_name' => 'nullable',
            'module_url' => 'nullable',
            'module_list_url' => 'nullable',
            'status' => 'nullable',
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $modules = new Modules();

        $modules->module_name = $request->module_name;
        $modules->module_short_name = $request->module_short_name;
        $modules->module_url = $request->module_url;
        $modules->module_list_url = $request->module_list_url;
        $modules->status = $request->status;
        $modules->save();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Modules created successfully!',
            'modules_id' => $modules->id
        ], 200);
    }

  public function updateModules(Request $request, $id)
{
    // Log the incoming request data
    \Log::info('Request Data:', $request->all());

    // Find the existing module
    $module = Modules::find($id);

    if (!$module) {
        return response()->json([
            'status' => false,
            'message' => 'Module not found',
        ], 404);
    }

    // Validation rules
    $validator = Validator::make($request->all(), [
        'module_name' => 'required|string|max:255',
        'module_short_name' => 'nullable|string|max:255',
        'module_url' => 'nullable|url|max:255',
        'module_list_url' => 'nullable|url|max:255',
        'status' => 'nullable|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

    // Update module
    $module->module_name = $request->input('module_name');
    $module->module_short_name = $request->input('module_short_name');
    $module->module_url = $request->input('module_url');
    $module->module_list_url = $request->input('module_list_url');
    $module->status = $request->input('status');
    
    try {
        $module->save();
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while updating the module.',
            'error' => $e->getMessage(),
        ], 500);
    }

    // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Module updated successfully!',
    ], 200);
}



    // get all salesexecutives
    public function getModules()
    {
        $modules = Modules::get();
        return response()->json([
            'status' => true,
            'message' => 'All modules',
            'modules' => $modules
        ], 200);
    }

    // get a specific teamleader
    public function getOneModules($id)
    {
        $modules = Modules::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'modules details',
            'modules' => $modules
        ], 200);
    }

    // delete a teamleader
    public function deleteModules($id)
    {
        $Modules = Modules::find($id);
        if (!$Modules) {
            return response()->json([
                'status' => false,
                'message' => 'Modules not found'
            ], 404);
        }
       
        $Modules->delete();

        return response()->json([
            'status' => true,
            'message' => 'Modules deleted successfully'
        ], 200);
    }
}
