<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Notices,Admins};
use File;

class NoticeController extends Controller
{
    public function createNotice(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'admin_id' => 'required|exists:admins,id',
        'category' => 'required',
        'notice_title' => 'required',
        'notice_image' => 'required',
        'url' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'status' => 'required',
    ]);

          if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ], 422);
    }

    $notices = new Notices();

     // Handle file upload
          if (isset($request->notice_image)) {
                // upload image
        $imageName = time() . '.' . $request->notice_image->extension();
        $request->notice_image->move(public_path('upload'), $imageName);
            $notices->notice_image = $imageName;
        }

        $notices->admin_id = $request->admin_id;
        $notices->category = $request->category;
        $notices->notice_title = $request->notice_title;
        $notices->url = $request->url;
        $notices->start_date = $request->start_date;
        $notices->end_date = $request->end_date;
        $notices->status = $request->status;
        $notices->save();
         // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Notices created successfully!'
    ], 200);
    
    }
    
    
    // get all notice probelm
       public function getAllNotice()
    {
        $notices = Notices::all(); // Fetch all notices
        
        if ($notices->isEmpty()) { // Check if the collection is empty
            return response()->json([
                'status' => true,
                'message' => 'No Notice Found',
                'notices' => [] // Return an empty array
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'All Notices',
                'notices' => $notices // Return the notices
            ], 200);
        }
    }

    
    // get all notice by admin
      public function getAllNoticeByAdmin(Request $request)
    {
         $notice = Notices::where('admin_id',$request->admin_id)->get();
         
          if ($notices->isEmpty()) { // Check if the collection is empty
            return response()->json([
                'status' => true,
                'message' => 'No Notice Found',
                'notices_by_admin' => [] // Return an empty array
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'All Notices',
                'notices_by_admin' => $notices // Return the notices
            ], 200);
        }
    }
    
    
   public function deleteNotice(Request $request, $id)
{
    // Find the notice by ID
    $notice = Notices::find($id);
    
    // Check if the notice exists
    if (!$notice) {
        return response()->json([
            'status' => false,
            'message' => 'Notice not found'
        ], 404);
    }

    // Prepare the path for the notice image
    $imagePath = public_path('upload') . '/' . $notice->notice_image;
    
    // Check if the image file exists and delete it
    if (File::exists($imagePath)) {
        File::delete($imagePath);
    }
    
    // Delete the notice from the database
    $notice->delete();
    
    return response()->json([
        'status' => true,
        'message' => 'Notice deleted successfully'
    ], 200);
}
    
}
// 

