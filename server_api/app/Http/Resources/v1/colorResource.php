<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class colorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'price' => $this->whenPivotLoaded('tbl_product_color', function () {
                    return $this->pivot->price;
                }),
            'image' => DB::table('tbl_product_color_image')->where('color_id',$this->id)->first()
        ];
    }
}
