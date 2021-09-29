<?php

namespace App\Http\Resources\gasht;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class GashtSingleResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'agency_id'=>$this->agency_id,
            'city_id'=>$this->city_id,
            'date'=>Jalalian::forge(strtotime($this->date))->format('Y/m/d'),
            'main_date'=>$this->date,
            'desc'=>$this->desc,
            'adult'=>$this->adult,
            'child'=>$this->child,
            'services'=>$this->services,
            'supplies'=>$this->supplies,
            'capacity'=>$this->capacity,
            'minCount'=>$this->minCount,
            'rand'=>$this->rand,
            'image' => $this->when($this['image'],url('/'). '/'. $this['image'], null),
            'city'=>new city($this->city),
            'agency'=> new agency($this->agency),
        ];
    }
}
