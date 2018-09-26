<?php

namespace App\Http\Controllers;

use App\Score;

class ScoresController extends Controller
{
    public function show($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return false;
        }

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
