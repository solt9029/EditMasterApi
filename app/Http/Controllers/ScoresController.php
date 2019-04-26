<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ScoreRepositoryInterface;
use App\Http\Requests\ScoreCreateRequest;

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

    public function timeline(Request $request)
    {
        $count = null !== $request->input('count') ? $request->input('count') : 24;
        $keyword = null !== $request->input('keyword') ? $request->input('keyword') : '';
        $max_id = null !== $request->input('max_id') ? $request->input('max_id') : null;
        $since_id = null !== $request->input('since_id') ? $request->input('since_id') : 0;

        $scores = $this->score_repository->getTimelineRecords($count, $keyword, $max_id, $since_id);

        return response()->json($scores, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $score = $this->score_repository->findById($id);
        if (!$score) {
            return response()->json(['message' => 'Not found.'], 404, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(ScoreCreateRequest $request)
    {
        $score = $this->score_repository->create($request);

        return response()->json($score, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
