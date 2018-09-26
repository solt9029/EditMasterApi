<?php

namespace App\Http\Controllers;

use App\Score;

class ScoresController extends Controller
{
    public function show($id)
    {
        $score = Score::find($id);

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
