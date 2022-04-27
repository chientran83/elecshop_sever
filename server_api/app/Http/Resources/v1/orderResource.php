<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $deliveryInformation = DB::table('tbl_delivery_information')->where('id',$this->deliveryInformation_id)->first();
        if(empty( $deliveryInformation)){
            $deliveryInformation = null;
        }
        $user = DB::table('users')->where('id',$deliveryInformation->user_id)->first();
        if(empty( $user)){
            $user = null;
        }
        $product = DB::table('tbl_product')->where('id',$this->product_id)->first();
        $color =  DB::table('tbl_colors')->where('id',$this->color_id)->first();
        if(empty($color)){
            $color = null;
        }
        $productTag =  DB::table('tbl_product_tag')->where('product_id',$this->product_id)->where('tag_id',$this->tags_id)->first();
        if(empty($productTag)){
            $tag = null;
        }else{
            $tagItem = DB::table('tbl_tags')->where('id',$productTag->tag_id)->first();
            if($tagItem){
                $tag = [
                    'id' => $productTag->id,
                    'name' => $tagItem->name,
                    'price' => $productTag->price
                ];
            }else{
                $tag = null;
            }
        }
        $productMemory =  DB::table('tbl_product_memory')->where('product_id',$this->product_id)->where('memory_id',$this->memory_id)->first();
        if(empty($productMemory)){
            $memory = null;
        }else{
            $memoryItem = DB::table('tbl_memories')->where('id',$productMemory->memory_id)->first();
            $memory = [
                'id' => $productMemory->id,
                'name' => $memoryItem->name,
                'price' => $productMemory->price
            ];
        }
        return [
            'id' => $this->id,
            'user_id' => DB::table('users')->where('id',$this->user_id)->first(),
            'product' => $product,
            'coupon' => DB::table('tbl_coupons')->where('id',$this->coupon_id)->first(),
            'price_total' => $this->price_total,
            'date' => $this->date,
            'deliveryInformation' => [
                    'id' => $deliveryInformation->id,
                    'phone' => $deliveryInformation->phone,
                    'address' => $deliveryInformation->address,
                    'name' => $deliveryInformation->name,
                    'user' => $user
                ],
            'quantity' => $this->quantity,
            'method_payment' => $this->method_payment,
            'color' => $color,
            'tag' =>  $tag,
            'memory' => $memory,
            'status' => $this->status
        ];
    }
}
