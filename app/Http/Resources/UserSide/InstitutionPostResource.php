<?php

namespace App\Http\Resources\UserSide;

use App\Http\Resources\Admin\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionPostResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'type'=>$this->type,
            'description'=>$this->description,
            'woreda'=>$this->woreda?? null,
            'kebele'=>$this->kebele?? null,
            'zone'=>$this->zone?? null,
            'region'=>$this->zone->region?? null,
            'posted_by'=>$this->postedBy?? null,
            'image'=> new ImageResource($this->images()->inRandomOrder()->first()) ?? null,
        ];
    }
}
