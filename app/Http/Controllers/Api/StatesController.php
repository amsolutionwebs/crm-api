<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\States;

class StatesController extends Controller
{
     public function getStates($id)
    {
        $states = States::where('country_id',$id)->get();
         return response()->json([
        'status' => true,
        'message' => 'All states',
        'states' => $states
    ], 200);
    }
}
