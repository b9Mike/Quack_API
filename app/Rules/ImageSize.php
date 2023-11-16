<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageSize implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Decodificar la imagen en base64
        $decodedImage = base64_decode($value);
            
        // Verificar que el tamaño no exceda de los 5KB
        if (strlen($decodedImage) > 5000) {
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
        return 'La imagen debe pesar menos de 5KB.';
    }
}
