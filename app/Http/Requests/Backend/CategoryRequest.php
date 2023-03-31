<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed slug
 * @property mixed category_name
 * @method category()
 */
class CategoryRequest extends FormRequest
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
    public function rules(): array
    {
        return [
           'category_name'      => ['required'],
//           'icon'               => ['required'],
           'slug'               => ['required', 'sometimes','unique:categories,slug'],
           'product_type_id'    => ['required'],
        ];
    }
//    public function messages()
//    {
//        return [
//            'icon.required' => 'The category image field is required.',
//        ];
//    }
}
