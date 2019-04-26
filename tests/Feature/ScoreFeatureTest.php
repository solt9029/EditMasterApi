<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Score;

class ScoreFeatureTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/scores');
        $response->assertStatus(200);
    }

    public function testTimeline()
    {
        $response = $this->get('/scores/timeline');
        $response->assertStatus(200);
    }

    public function testShowSuccess()
    {
        factory(Score::class)->create();
        $response = $this->get('/scores/1');
        $response->assertStatus(200);
    }

    public function testShowFailure()
    {
        $response = $this->get('/scores/10000');
        $response->assertStatus(404);
    }
}
