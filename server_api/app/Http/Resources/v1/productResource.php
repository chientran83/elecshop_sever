<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'tag' => $this->tag,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'tags' => Resource::collection($this->tags),
            'colors' => colorResource::collection($this->color),
            'memory' => Resource::collection($this->memory),
            'accessories' => Resource::collection($this->accessories),
        ];
        // return parent::toArray($request);
    }
}
