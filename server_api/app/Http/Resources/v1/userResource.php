<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
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
            'email' => $this->email,
            'location' => $this->location,
            'phoneNumber' => $this->phoneNumber,
            'image_path' => $this->image_path,
            'roles' => roleResource::collection($this->role),
            'deliveryInformation' => Resource::collection($this->deliveryInformation)
        ];
    }
}
