<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;
use App\Http\Resources\TourDetailsImages;

class TourDetails extends JsonResource
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
            'origin'=>$this->title_fa,
            'number_nights'=>$this->number_nights,
            'travel_method'=>$this->travel_method,
            'vehicle_type'=>$this->vehicle_type,
            'startDate'=>jalalian::forge($this->start_in)->format('Y/m/d'),
            'rules'=>strip_tags(str_replace('&nbsp;',' ',$this->rules)),
            'obligations'=>strip_tags(str_replace('&nbsp;',' ',$this->obligations)),
            'docs'=>strip_tags(str_replace('&nbsp;',' ',$this->documents)),
            'otherServices'=>strip_tags(str_replace('&nbsp;',' ',$this->additional_services)),
            'agency_id'=>$this->agency_id,
            'agency_name'=>$this->company,
            'agency_domain'=>$this->domain,
            'agency_tellPhone'=>$this->tellphone,
            'agency_InetrnalPhone'=>$this->when(@$this->internalCode,'05131600'.@$this->internalCode,null),
            'agency_cellPhone'=>$this->cellphone,
            'agency_email'=>$this->email,
            'agency_address'=>$this->address,
            'startPrice'=>$this->minPrice,
            'cities' => $this->cities, 
            'levels'=> $this->levels,
            'maps'=> $this->maps,
            'prices'=> $this->prices,
            'services'=> $this->services,
            'images'=> new TourDetailsImages($this->images)
        ];
    }
}
