<?php

namespace App\Http\Controllers;

use App\Score;
use Illuminate\Http\Request;
use App\Rules\ValidVideoId;
use App\Rules\ValidNotes;

class ScoresController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Score::query();
        $columns = ['username', 'comment', 'video_id', 'bpm', 'offset', 'speed'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$keyword}%");
        }
        $scores = $query->latest('id')->paginate(24);

        return response()->json($scores, 200, [], JSON_UNESCAPED_UNICODE);
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

        $score = Score::create([
            'username' => $request->username,
            'comment' => $request->comment,
            'video_id' => $request->videoId,
            'bpm' => $request->bpm,
            'offset' => $request->offset,
            'notes' => json_encode($request->notes),
            'speed' => $request->speed,
            // 'advanced_settings' => null,
        ]);

        return response()->json(['message' => 'Created successfully!', 'id' => $score->id], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
