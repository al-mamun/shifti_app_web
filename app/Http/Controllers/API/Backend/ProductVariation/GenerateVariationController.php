<?php

namespace App\Http\Controllers\API\Backend\ProductVariation;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateVariationController extends Controller
{

    public function product_variation_combination(Request $request)
    {
        if ($request->attribute_name_0) {

            $i = 0;
            $product_attributes = [];
            $attribute_name = [];
            $attribute_value = [];

            while ($request->input('attribute_name_' . $i)) {
                // array_push($product_attributes, ['attribute_name'=>ucwords($request->input('attribute_name_'.$i)) ]);
                $temp_name = ['attribute_name' => ucwords(trim($request->input('attribute_name_' . $i), ' '))];
                array_push($attribute_name, ucwords(trim($request->input('attribute_name_' . $i), ' ')));
                $product_attribute['attribute_name'] = ucwords(trim($request->input('attribute_name_' . $i), ' '));


                $old_attribute = ProductAttribute::where('attribute_name', ucwords(trim($request->input('attribute_name_' . $i), ' ')))->first();
                if (!$old_attribute) {
                    $created_attribute = ProductAttribute::create($product_attribute);
                    $attribute_id = $created_attribute->id;
                } else {
                    $attribute_id = $old_attribute->id;
                }

                $attribute = $request->input('attribute_value_' . $i);

                $attribute = str_replace('|', ',', $attribute);
                $attribute = str_replace(' |', ',', $attribute);
                $attribute = str_replace(' | ', ',', $attribute);
                $attribute = str_replace('| ', ',', $attribute);
                $attribute = str_replace(', ', ',', $attribute);
                $attribute = str_replace(' , ', ',', $attribute);
                $attribute = str_replace(', ', ',', $attribute);
                $temp_value = explode(',', $attribute);
                array_push($attribute_value, $temp_value);
                $i++;
            }

            $attributes = array_combine($attribute_name, $attribute_value);
            $combinations = $this->possible_combos($attributes);
            $formatted_combo = [];
            foreach ($combinations as $value) {
                $tem_data = explode('|', $value);
                $tem_array = [];
                foreach ($tem_data as $key => $data) {
                    $temp_arr = [$attribute_name[$key] => $data];
                    array_push($tem_array, $temp_arr);
                }
                array_push($formatted_combo, $tem_array);
                $tem_array = [];
                $tem_data = '';
            }
            $combination_id = 1;

            $variation_new_data_for_check = [];
            foreach ($formatted_combo as $combo) {

                foreach ($combo as $data) {

                    foreach ($data as $key => $combo_value) {
                        $variation_name = ProductAttribute::where('attribute_name', $key)->first();
                        $product_attribute_data['product_id'] = $request->product_id;
                        $product_attribute_data['attribute_value'] = $combo_value;
                        $product_attribute_data['product_attribute_id'] = $variation_name->id;
                        $product_attribute_data['sku_variation_id'] = $combination_id;

                        $variation_old_data = ProductAttributeValue::where('product_id', $request->product_id)->where('attribute_value', $combo_value)->where('product_attribute_id', $variation_name->id)->where('sku_variation_id', $combination_id)->first();

                        if (!$variation_old_data) {
                            $variation_created = ProductAttributeValue::create($product_attribute_data);
                            array_push($variation_new_data_for_check, $variation_created->id);
                        } else {
                            array_push($variation_new_data_for_check, $variation_old_data->id);
                        }

                    }

                }
                $combination_id++;
            }
        }

        $old_attribute_value = ProductAttributeValue::where('product_id', $request->product_id)->get();

        foreach ($old_attribute_value as $old_attribute_data) {
            if (!in_array($old_attribute_data->id, $variation_new_data_for_check)) {
                $old_attribute_data->delete();
            }
        }

        $variation_combination_count = ProductAttributeValue:: where('product_id', $request->product_id)->distinct('sku_variation_id')->count();
        $variation_name_database = ProductAttributeValue::select('product_attribute_id')->with('attribute_name')->where('product_id', $request->product_id)->distinct('product_attribute_id')->get();
        $product_attribute_name = [];
        foreach ($variation_name_database as $variation_name_data) {
            array_push($product_attribute_name, $variation_name_data->attribute_name->attribute_name);
        }

        $combination_array = [];

        for ($i = 1; $i <= $variation_combination_count; $i++) {
            $temp_variations = ProductAttributeValue::where('product_id', $request->product_id)->where('sku_variation_id', $i)->get();
            $temp_multiple_array = [];
            foreach ($temp_variations as $temp_variation) {
                $temp_single_array = ['id' => $temp_variation->id, 'attribute_value' => $temp_variation->attribute_value, 'sku_variation_id' => $temp_variation->sku_variation_id];
                array_push($temp_multiple_array, $temp_single_array);
            }
            array_push($combination_array, $temp_multiple_array);
            $temp_multiple_array = [];
        }
        $final_data = ['attribute_name' => $product_attribute_name, 'combinations' => $combination_array];

        return response()->json(['attribute_name' => $product_attribute_name, 'combinations' => $combination_array]);

    }


    public function get_product_variation_combination($id)
    {
        $variation_combination_count = ProductAttributeValue:: where('product_id', $id)->distinct('sku_variation_id')->count();
        $variation_name_database = ProductAttributeValue::select('product_attribute_id')->with('attribute_name')->where('product_id', $id)->distinct('product_attribute_id')->get();
        $product_attribute_name = [];
        foreach ($variation_name_database as $variation_name_data) {
            array_push($product_attribute_name, $variation_name_data->attribute_name->attribute_name);
        }

        $combination_array = [];

        $database_combination_datas = ProductAttributeValue::select('sku_variation_id')->where('product_id', $id)->distinct()->get();


        foreach ($database_combination_datas as $database_combination_data) {
            $temp_variations = ProductAttributeValue::where('product_id', $id)->where('sku_variation_id', $database_combination_data->sku_variation_id)->get();
            $temp_multiple_array = [];
            foreach ($temp_variations as $temp_variation) {
                $temp_single_array = ['id' => $temp_variation->id, 'attribute_value' => $temp_variation->attribute_value, 'sku_variation_id' => $temp_variation->sku_variation_id];
                array_push($temp_multiple_array, $temp_single_array);
            }
            array_push($combination_array, $temp_multiple_array);
            $temp_multiple_array = [];
        }
        return response()->json(['attribute_name' => $product_attribute_name, 'combinations' => $combination_array]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generate_variations(Request $request)
    {
        $attributes = [];
        $attribute_value = [];
        $attribute_name = [];
        foreach ($request->except('id') as $key => $value) {
            $temp_name = explode('_', $key);
            if ($temp_name[1] == 'name') {
                array_push($attribute_name, $value);
            } elseif ($temp_name[1] == 'value') {
                $temp_value = explode(',', $value);
                array_push($attribute_value, $temp_value);
            }
        }

        $attributes = array_combine($attribute_name, $attribute_value);

//        foreach ($attribute_name as $key=> $name){
//            $product_attribute['attribute_name'] = $name;
//            $product_attribute['product_id'] = $request->id;
//            $product_attribute_saved = ProductAttribute::create($product_attribute);
//            foreach ($attribute_value as $attr_key=>$attr_value){
//                foreach ($attr_value as $single_attr_value){
//                    if ($attr_key == $key){
//                        $database_data['product_attribute_id']= $product_attribute_saved->id;
//                        $database_data['attribute_value']= $single_attr_value;
//                       // ProductAttributeValue::create($database_data);
//                    }
//                }
//            }
//        }

        $combinations = $this->possible_combos($attributes);
        $formatted_combo = [];
        foreach ($combinations as $key => $value) {
            $tem_data = explode('|', $value);
            array_push($formatted_combo, $tem_data);
            $tem_data = '';
        }
        //store variations

//        foreach ($formatted_combo as $combo){
//            $variation['name']=$combo[0];
//            $variation['value']=$combo[1];
//            $variation['product_id']=$request->id;
//            ProductVariation::create($variation);
//        }
        return response()->json($formatted_combo);
    }

    /**
     * @param $groups
     * @param string $prefix
     * @return array
     */
    function possible_combos($groups, string $prefix = ''): array
    {
        $result = array();
        $group = array_shift($groups);
        foreach ($group as $selected) {
            if ($groups) {
                $result = array_merge($result, $this->possible_combos($groups, $prefix . $selected . '|'));
            } else {
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }


    public function test(Request $request)
    {

        if ($request->attribute_name_0) {
            $i = 0;
            $product_attributes = [];
            $attribute_name = [];
            $attribute_value = [];

            while ($request->input('attribute_name_' . $i)) {
                // array_push($product_attributes, ['attribute_name'=>ucwords($request->input('attribute_name_'.$i)) ]);
                $temp_name = ['attribute_name' => ucwords($request->input('attribute_name_' . $i))];
                array_push($attribute_name, ucwords($request->input('attribute_name_' . $i)));
                $product_attribute['attribute_name'] = ucwords($request->input('attribute_name_' . $i));


                $old_attribute = ProductAttribute::where('attribute_name', ucwords($request->input('attribute_name_' . $i)))->first();
                if (!$old_attribute) {
                    $created_attribute = ProductAttribute::create($product_attribute);
                    $attribute_id = $created_attribute->id;
                } else {
                    $attribute_id = $old_attribute->id;
                }

                $attribute = $request->input('attribute_value_' . $i);

                $temp_value = explode(',', $attribute);
                array_push($attribute_value, $temp_value);
                $i++;
            }

            $attributes = array_combine($attribute_name, $attribute_value);

            $combinations = $this->possible_combos2($attributes);
            $formatted_combo = [];
            foreach ($combinations as $value) {
                $tem_data = explode('|', $value);
                $tem_array = [];
                foreach ($tem_data as $key => $data) {
                    $temp_arr = [$attribute_name[$key] => $data];
                    array_push($tem_array, $temp_arr);
                }
                array_push($formatted_combo, $tem_array);
                $tem_array = [];
                $tem_data = '';
            }
            $combination_id = 1;
            foreach ($formatted_combo as $combo) {

                foreach ($combo as $data) {

                    foreach ($data as $key => $combo_value) {
                        $variation_name = ProductAttribute::where('attribute_name', $key)->first();
                        $product_attribute_data['product_id'] = 638;
                        $product_attribute_data['attribute_value'] = $combo_value;
                        $product_attribute_data['product_attribute_id'] = $variation_name->id;
                        $product_attribute_data['sku_variation_id'] = $combination_id;
                        ProductAttributeValue::create($product_attribute_data);
                    }

                }
                $combination_id++;
            }


            return $formatted_combo;
        }
    }


    function possible_combos2($groups, string $prefix = '')
    {

        $result = [];
        $group = array_shift($groups);
        //  return $group;

        foreach ($group as $key => $selected) {
//return $key;
            if ($groups) {
                $result = array_merge($result, $this->possible_combos($groups, $prefix . $selected . '|'));
            } else {
                return 'else';
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }

    public function add_custom_variation_field(Request $request)
    {

        if($request->exists('product_id')){
            $i = 0;
            $attribute_data_array = [];
            while ($request->input('variationName_' . $i)) {

                $product_attribute['attribute_name'] = ucwords($request->input('variationName_' . $i));


                $old_attribute = ProductAttribute::where('attribute_name', ucwords($request->input('variationName_'.$i)))->first();

                $old_attribute;
                if ($old_attribute) {
                    $attribute_id = $old_attribute->id;
                }
                $attribute_data_array_temp['attribute_value'] = $request->input('variationValue_' . $i);
                $attribute_data_array_temp['product_attribute_id'] = $attribute_id;
                array_push($attribute_data_array, $attribute_data_array_temp);

                $i++;
            }


            $last_variation_id = ProductAttributeValue::where('product_id', $request->input('product_id'))->orderBy('sku_variation_id', 'desc')->first();
            if($last_variation_id){
                $last_variation_id = $last_variation_id->sku_variation_id+1;
            }else{
                $last_variation_id = 1;
            }
            foreach ( $attribute_data_array as  $attribute_data){
                $attribute_data['product_id'] = $request->input('product_id');
                $attribute_data['sku_variation_id'] = $last_variation_id;
                ProductAttributeValue::create($attribute_data);
            }
        return response()->json(['msg'=>'Variation Added Successfully']);
        }
        return null;
    }
}
