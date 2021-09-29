<?php

namespace App\Http\Resources\transfer;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class TransferSingleResource extends JsonResource
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
            'agency_id' => $this->agency_id,
            'city_id' => $this->city_id,
            'date' => Jalalian::forge(strtotime($this->date))->format('Y/m/d'),
            'rand' => $this->rand,
            'city' => new city($this->city),
            'agency' => new agency($this->agency),
            'items' => $this->titems
        ];
    }
}
