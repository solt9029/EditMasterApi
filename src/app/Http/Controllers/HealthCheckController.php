<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ScoreRepositoryInterface;
use App\Http\Requests\ScoreCreateRequest;

class HealthCheckController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([], 200);
    }
}
