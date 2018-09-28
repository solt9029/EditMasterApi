<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidNotes implements Rule
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
        if (0 !== count($value) % 96) {
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
        return '譜面データが正しくありません。';
    }
}
