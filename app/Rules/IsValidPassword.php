<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class IsValidPassword implements Rule
{
    /**
     * Determine if the Length Validation Rule passes.
     *
     * @var boolean
     */
    public $lengthPasses = true;

    /**
     * Determine if the Uppercase Validation Rule passes.
     *
     * @var boolean
     */
    public $uppercasePasses = true;

    /**
     * Determine if the Numeric Validation Rule passes.
     *
     * @var boolean
     */
    public $numericPasses = true;

    /**
     * Determine if the Special Character Validation Rule passes.
     *
     * @var boolean
     */
    public $specialCharacterPasses = true;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->uppercasePasses = (Str::lower($value) !== $value);
        $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));

        return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case ! $this->uppercasePasses
                && $this->numericPasses:
                return __('The :attribute must be at least 8 characters and contain at least one uppercase character', ['attribute'=>$attribute]);

            case ! $this->numericPasses
                && $this->uppercasePasses:
                return __('The :attribute must be at least 8 characters and contain at least one number', ['attribute'=>$attribute]);

            case ! $this->uppercasePasses
                && ! $this->numericPasses:
                return __('The :attribute must be at least 8 characters and contain at least one uppercase character and one number', ['attribute'=>$attribute]);

            case ! $this->uppercasePasses
                && $this->numericPasses:
                return __('The :attribute must be at least 8 characters and contain at least one uppercase character and one special character', ['attribute'=>$attribute]);

            case ! $this->uppercasePasses
                && ! $this->numericPasses:
                return __('The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character', ['attribute'=>$attribute]);

            default:
                return __('The :attribute must be at least 8 characters', ['attribute'=>$attribute]);
        }
    }
}