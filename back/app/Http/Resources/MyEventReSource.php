<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyEventReSource extends JsonResource
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
            "id"=>$this->id,
            "title"=>$this->title,
            "descriptoin"=>$this->description,
            "country"=>$this->country,
            "city"=>$this->city,
            "start_date"=>$this->start_date,
            "end_date"=>$this->end_date,
            "image"=>$this->image,
            "user_id"=>$this->user_id,
            "category_id"=>$this->category_id,
            "created_at"=>$this->created_at->format('D, j M Y h:i A'),
            "updated_at"=>$this->updated_at->format('D, j M Y h:i A'),
        ];
    }
}
