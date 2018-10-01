<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Score;
use Illuminate\Database\QueryException;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Score::unguard();
        $count = 1032;
        for ($i = 0; $i < $count; ++$i) {
            $url = "http://host.docker.internal:8007/Scores/migrate?id=${i}";
            $result = file_get_contents($url);
            if ('' === $result) {
                echo "${i} seems to be empty...\n";
                continue;
            }
            $result = json_decode($result);

            try {
                Score::create([
                    'id' => $result->id,
                    'username' => $result->username,
                    'comment' => $result->comment,
                    'video_id' => $result->video_id,
                    'bpm' => $result->bpm,
                    'offset' => $result->offset,
                    'notes' => json_encode($result->notes),
                    'speed' => $result->speed,
                    'advanced_settings' => null,
                    'created_at' => $result->date,
                ]);
                echo "${i} has been successfully imported!\n";
            } catch (QueryException $e) {
                echo "${i} has not been imported...\n";
                echo "error: ${e}\n";
            }
        }
    }
}
