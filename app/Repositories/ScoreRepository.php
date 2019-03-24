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
        return $this->score->find($id);
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

        return $query->orderBy('id', 'DESC')->take($count)->get();
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
        $scores = $query->latest('id')->paginate($page_num);

        return $scores;
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
            'notes' => $data->notes,
            'speed' => $data->speed,
            // 'advanced_settings' => null,
        ]);

        return $score;
    }
}
