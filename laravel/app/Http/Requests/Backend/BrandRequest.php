<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed brand_name
 * @property mixed slug
 */
class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['brand_name' => "string[]", 'slug' => "string[]"])] public function rules(): array
    {
        return [
            'brand_name'  => ['required'],
            'slug'        => ['required','unique:brands,slug'],
        ];
    }
}
