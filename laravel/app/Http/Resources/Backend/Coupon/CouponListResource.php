<?php

namespace App\Http\Resources\Backend\Coupon;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $expire_date
 * @property mixed $id
 * @property mixed $code
 * @property mixed $discount_amount
 * @property mixed $discount_type
 * @property mixed $description
 * @property mixed $status
 * @property mixed $user_id
 * @property mixed $foreign_key
 * @property mixed $applied_to
 * @property mixed $user
 */
class CouponListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        if ($this->expire_date != null) {
            $date = date_create($this->expire_date);
            $expire = date_format($date, 'd-m-Y');
        } else {
            $expire = 'No Expire date';
        }

        if ($this->discount_type == 1) {
            $discount_amount = $this->discount_amount . '%';
        }else{
            $discount_amount = '৳'. $this->discount_amount ;
        }

        $foreign_key = null;
        if ( $this->applied_to == 1) {
            $applied_to = 'All Product';
        }elseif ($this->applied_to == 2){
            $foreign_key = Category::select('category_name')->findOrFail($this->foreign_key);
            $foreign_key = $foreign_key['category_name'];
            $applied_to = 'Category';
        }elseif ($this->applied_to == 3){
            $applied_to = 'Sub Category';
            $foreign_key = Category::select('category_name')->findOrFail($this->foreign_key);
            $foreign_key = $foreign_key['category_name'];
        }elseif ($this->applied_to == 4){
            $applied_to = 'Product';
            $foreign_key = Product::select('product_name')->findOrFail($this->foreign_key);
            $foreign_key = $foreign_key['product_name'];
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'expire_date' => $expire,
            'discount_amount' =>$discount_amount,
            'amount' =>$this->discount_amount,
            'symbol' =>$this->discount_type == 1 ? '%': '৳',
            'description' => $this->description,
            'status' => $this->status == 1?'Active' : 'Inactive',
            'user' => $this->user?->name,
            'applied_to' =>$applied_to,
            'foreign_key' => $foreign_key,
        ];
    }
}
