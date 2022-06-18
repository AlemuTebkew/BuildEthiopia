<?php

namespace App\Http\Resources\UserSide;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'full_name'=>$this->full_name,
            'address'=>$this->address,
            'email'=>$this->email,
            'word_of_support'=>$this->word_of_support,
            'currency_code'=>$this->currency_code,
            'donation_amount'=>$this->donation_amount,
            'donated_to'=>$this->donated_to,
            'is_visible'=>$this->is_visible,
            'created_at'=>$this->created_at,

            ];
    }
}
