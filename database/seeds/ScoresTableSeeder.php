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
        $note_ids_array = [];
        for ($i = 0; $i < 96 * 2; ++$i) {
            if (0 === $i % 24) {
                $note_ids_array[] = 1;
            } else {
                $note_ids_array[] = 0;
            }
        }
        $note_ids_json = json_encode($note_ids_array);

        for ($i = 0; $i < 1000; ++$i) {
            DB::table('scores')->insert([
                'username' => '通りすがりの創作の達人',
                'comment' => '創作譜面をしました。',
                'video_id' => 'rnSsptZaYsM',
                'bpm' => 180,
                'offset' => 1.7,
                'note_ids' => $note_ids_json,
                'speed' => 1,
                'advanced_settings' => null,
            ]);
        }
    }
}
