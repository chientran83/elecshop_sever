<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class cartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = [];
        $getAllProductInCart = DB::table('tbl_cart_product')->where('cart_id',$this->id)->get();
        foreach ($getAllProductInCart as $key => $value) {
            $products[] = $value;
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'quantity' => $this->quantity,
            'products' => $products
        ];
    }
}
