<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([], 200);
    }
}
