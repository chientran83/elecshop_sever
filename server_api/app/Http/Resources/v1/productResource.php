<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
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
            'current_price' => $this->current_price,
            'previous_price' => $this->previous_price,
            'origin_price' => $this->origin_price,
            'image_path' => $this->image_path,
            'ram' => $this->ram,
            'desc' => $this->desc,
            'isOnSale' => $this->isOnSale,
            'quantity' => $this->quantity,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'tags' => Resource::collection($this->tag)
        ];
        /* return parent::toArray($request); */
    }
}
