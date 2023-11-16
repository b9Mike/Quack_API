<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Number implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Verificar si al menos hay un número en la cadena
        return preg_match('/[0-9]/', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "La :attribute debe contener al menos un número.";
    }
}
