<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidVideoId;
use App\Rules\ValidNotes;

class ScoreCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'max:20'],
            'video_id' => ['required', new ValidVideoId()],
            'bpm' => ['required', 'numeric'],
            'offset' => ['required', 'numeric'],
            'speed' => ['required', 'numeric'],
            'comment' => 'max:140',
            'notes' => ['required', new ValidNotes()],
        ];
    }
}
