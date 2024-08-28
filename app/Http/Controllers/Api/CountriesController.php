<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries;

class CountriesController extends Controller
{
    public function getCountry()
    {
        $country = Countries::get();
         return response()->json([
        'status' => true,
        'message' => 'All Country',
        'country' => $country
    ], 200);
    }

     public function getCountryIndia()
    {
        $country = Countries::where('id','101')->first();
         return response()->json([
        'status' => true,
        'message' => 'Country India',
        'india_country' => $country
    ], 200);
    }
}
