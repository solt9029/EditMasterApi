<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidVideoId implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $youtube_api_key = env('YOUTUBE_API_KEY');
        $video_data_json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=${value}&key=${youtube_api_key}&fields=items(id)&part=contentDetails");
        $video_data_obj = json_decode($video_data_json);
        if (0 === count($video_data_obj->items)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '指定されたYouTube動画IDは存在しません。';
    }
}
