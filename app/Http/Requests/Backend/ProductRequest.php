<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed slug
 * @property mixed tag_name
 * @property mixed product_name
 * @property mixed keywords
 * @property mixed description
 * @property mixed category_id
 * @property mixed tag
 * @property mixed brand
 */
class ProductRequest extends FormRequest
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
            //main product
            'description'            => 'required',
            'discount_percent'       => 'numeric',
            'price'                  => 'required|numeric',
            'product_cost'           => 'required|numeric',
            'product_name'           => 'required|max:255',
            'product_type_id'        => 'required',
            'category_id'            => 'required',
            'sku'                    => 'required',
            'product_slug'                   => 'required|unique:products,slug',
            'status'                 => 'required',
            'stock'                  => 'required',
            'feature_photo'          => 'required',

            //delivery information



        ];
    }
}
