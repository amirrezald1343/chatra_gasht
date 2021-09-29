<?php

namespace App\Http\Resources\transfer;

use Illuminate\Http\Resources\Json\JsonResource;

class agency extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'tellPhone' => $this->tellPhone,
            'email' => $this->email
        ];
    }
}
