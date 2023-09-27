<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageUrlCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if($value){
            if(!str($value)->isUrl()){
                return Storage::url($value);
            }

            return $value;
        }else{
            return null;
        }
        // 'http://localhost:8000/storage/uploads/posts/banners//l9PAihmMRCyfEqQ1UaoLYOgZNT208L76SabeUAXZ.png'
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
