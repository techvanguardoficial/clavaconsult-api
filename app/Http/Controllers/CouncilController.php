<?php

namespace App\Http\Controllers;

use App\Models\Council;
use Illuminate\Http\Request;

class CouncilController extends Controller
{
    public function index()
    {
        $council = Council::all();

        if($council) {
            return response()->json($council, 200);
        }
    }
}
