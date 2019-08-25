<?php

use Faker\Generator as Faker;
use App\Score;

$factory->define(Score::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'comment' => $faker->text,
        'video_id' => generateFakeVideoId(),
        'bpm' => mt_rand(100, 200),
        'offset' => mt_rand(1, 10),
        'notes' => generateFakeNotes(),
        'speed' => mt_rand(1, 3),
        'advanced_settings' => null,
    ];
});

function generateFakeVideoId()
{
    $video_ids = ['rnSsptZaYsM', 'E6EMm88R4Ck', 'poiZSEjQBgw', 'O26hv3RntgA', 'JwmTXEWr41U'];

    return $video_ids[mt_rand(0, count($video_ids) - 1)];
}

function generateFakeNotes()
{
    $notes_array = [];
    $notes_per_bar = 96;
    $bar_num = mt_rand(3, 5);
    for ($j = 0; $j < $notes_per_bar * $bar_num; ++$j) {
        $note = 0;
        if (0 === $j % ($notes_per_bar / 16)) {
            $note = mt_rand(0, 4);
        }
        $notes_array[] = $note;
    }
    $notes_json = json_encode($notes_array);

    return $notes_json;
}
