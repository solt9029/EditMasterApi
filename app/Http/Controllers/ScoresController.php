<?php

namespace App\Http\Controllers;

use App\Score;
use Illuminate\Http\Request;
use App\Rules\ValidVideoId;

class ScoresController extends Controller
{
    public function index()
    {
        return Score::latest('id')->paginate(24);
    }

    public function show($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return false;
        }

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request)
    {
        $request->validate([
            'username' => ['required', 'max:20'],
            'videoId' => ['required', new ValidVideoId()],
            'bpm' => ['required', 'numeric'],
            'offset' => ['required', 'numeric'],
            'speed' => ['required', 'numeric'],
            'comment' => 'max:140',
            'notes' => ['required', new ValidNotes()],
        ]);

        Score::create([
            'username' => $request->username,
            'comment' => $request->comment,
            'video_id' => $request->videoId,
            'bpm' => $request->bpm,
            'offset' => $request->offset,
            'notes' => json_encode($request->notes),
            'speed' => $request->speed,
            // 'advanced_settings' => null,
        ]);

        return response()->json(['message' => 'Created successfully!'], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
