<?php

namespace App\Repositories;

use App\Score;

class ScoreRepository implements ScoreRepositoryInterface
{
    protected $score;

    /**
     * @param object $score
     */
    public function __construct(Score $score)
    {
        $this->score = $score;
    }

    /**
     * find by id.
     *
     * @param int $id
     *
     * @return object
     */
    public function findById($id)
    {
        $score = $this->score->find($id);

        $score->notes = json_decode($score->notes);

        return $score;
    }

    /**
     * get records for timeline.
     *
     * @param int      $count
     * @param string   $keyword
     * @param int|null $max_id
     * @param int      $since_id
     */
    public function getTimelineRecords($count = 24, $keyword = '', $max_id = null, $since_id = 0)
    {
        $query = $this->score->query();

        $query->where('id', '>', $since_id);
        if (null !== $max_id) {
            $query->where('id', '<=', $max_id);
        }

        $columns = ['username', 'comment', 'video_id', 'bpm', 'offset', 'speed'];
        $query->where(function ($query) use ($columns, $keyword) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$keyword}%");
            }
        });

        $scores = $query->orderBy('id', 'DESC')->take($count)->get();

        foreach ($scores as $score) {
            $score->notes = json_decode($score->notes);
        }

        return $scores;
    }

    /**
     * keyword search and paginate.
     *
     * @param string $keyword
     * @param int    $page_num
     *
     * @return object
     */
    public function getPaginateRecordsByKeyword($keyword, $page_num)
    {
        $query = $this->score->query();
        $columns = ['username', 'comment', 'video_id', 'bpm', 'offset', 'speed'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$keyword}%");
        }
        $result = $query->latest('id')->paginate($page_num);

        foreach ($result->getCollection() as $score) {
            $score->notes = json_decode($score->notes);
        }

        return $result;
    }

    /**
     * create.
     *
     * @param object $data
     *
     * @return object
     */
    public function create($data)
    {
        $score = $this->score->create([
            'username' => $data->username,
            'comment' => $data->comment,
            'video_id' => $data->video_id,
            'bpm' => $data->bpm,
            'offset' => $data->offset,
            'notes' => json_encode($data->notes),
            'speed' => $data->speed,
            // 'advanced_settings' => null,
        ]);

        return $score;
    }
}
