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
            
            $product = DB::table('tbl_product')->where('id',$value->product_id)->first();
            $color =  DB::table('tbl_colors')->where('id',$value->color_id)->first();
            if(empty($color)){
                $color = null;
            }
            $productTag =  DB::table('tbl_product_tag')->where('product_id',$value->product_id)->where('tag_id',$value->tag_id)->first();
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
            $productMemory =  DB::table('tbl_product_memory')->where('product_id',$value->product_id)->where('memory_id',$value->memory_id)->first();
            if(empty($productMemory)){
                $memory = null;
            }else{
                $memory = "";
                $memoryItem = DB::table('tbl_memories')->where('id',$productMemory->memory_id)->first();
                $memory = [
                    'id' => $productMemory->id,
                    'price' => $productMemory->price,
                    'name' => $memoryItem->name
                ];
            }

            $products[] = [
                'product' => $product,
                'color' => $color,
                'memory' => $memory,
                'tag' => $tag,
                'quantity' =>  $value->quantity
            ];
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'quantity' => $this->quantity,
            'products' => $products,
            'price' => $this->price_total
        ];
    }
}
