<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class sliderResource extends JsonResource
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
            'desc' => $this->desc,
            'image_path' => $this->image_path,
            'link' => $this->link,
            'linkInformation' => $this->linkInformation,
            'name' => $this->name,
            'status' => $this->status,
            'products' => DB::table('tbl_product')->where('id',$this->product_id)->first()
            
        ];
    }
}
