<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ja_JP');

        for ($i = 0; $i < 100; ++$i) {
            $note_ids_array = [];
            $notes_per_bar = 96;
            $bar_num = mt_rand(3, 5);
            for ($j = 0; $j < $notes_per_bar * $bar_num; ++$j) {
                $note_id = 0;
                if (0 === $j % ($notes_per_bar / 16)) {
                    $note_id = mt_rand(0, 4);
                }
                $note_ids_array[] = $note_id;
            }
            $note_ids_json = json_encode($note_ids_array);

            $video_ids = ['rnSsptZaYsM', 'E6EMm88R4Ck', 'poiZSEjQBgw', 'O26hv3RntgA', 'JwmTXEWr41U'];

            DB::table('scores')->insert([
                'username' => $faker->userName,
                'comment' => $faker->text,
                'video_id' => $video_ids[mt_rand(0, 4)],
                'bpm' => mt_rand(100, 200),
                'offset' => mt_rand(1, 10),
                'note_ids' => $note_ids_json,
                'speed' => mt_rand(1, 3),
                'advanced_settings' => null,
            ]);
        }
    }
}
