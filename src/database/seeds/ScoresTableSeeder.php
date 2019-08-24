<?php

use Illuminate\Database\Seeder;
use App\Score;

class ScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(Score::class, 100)->create();
    }
}
