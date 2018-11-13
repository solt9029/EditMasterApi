<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidVideoId;
use App\Rules\ValidNotes;
use App\Repositories\ScoreRepositoryInterface;

class ScoresController extends Controller
{
    public function __construct(ScoreRepositoryInterface $score_repository)
    {
        $this->score_repository = $score_repository;
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $page_num = 24;
        $scores = $this->score_repository->getPaginateRecordsByKeyword($keyword, $page_num);

        return response()->json($scores, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $score = $this->score_repository->findById($id);
        if (!$score) {
            return false;
        }

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request)
    {
        $request->validate([
            'username' => ['required', 'max:20'],
            'video_id' => ['required', new ValidVideoId()],
            'bpm' => ['required', 'numeric'],
            'offset' => ['required', 'numeric'],
            'speed' => ['required', 'numeric'],
            'comment' => 'max:140',
            'notes' => ['required', new ValidNotes()],
        ]);

        $request->notes = json_encode($request->notes);
        $score = $this->score_repository->create($request);

        return response()->json(['message' => 'Created successfully!', 'id' => $score->id], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
