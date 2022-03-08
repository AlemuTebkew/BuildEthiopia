<?php

namespace App\Http\Resources\Admin;

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
            'title'=>$this->title,
            'type'=>$this->type,
            'description'=>$this->description,
            'woreda'=>$this->woreda?? null,
            'kebele'=>$this->kebele?? null,
            'zone'=>$this->zone?? null,
            'posted_by'=>$this->poster?? null,
        ];
    }
}
