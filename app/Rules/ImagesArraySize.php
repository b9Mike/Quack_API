<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImagesArraySize implements Rule
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
        // Iterar a través de cada imagen
        foreach ($value as $image) {

            // Decodificar la imagen en base64
            $decodedImage = base64_decode($image);
            
            // Verificar que el tamaño no exceda de los 5KB
            if (strlen($decodedImage) > 5000) {
                return false;
            }
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
        return 'Las imágenes deben pesar menos de 5KB.';
    }
}
