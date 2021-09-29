<?php

namespace App\Http\Resources\tour;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;
use App\Currency;

class TourDetailsResource extends JsonResource
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
            'title' => $this->title,
            'origin' => $this->origin,
            'start_in' => date('Y-m-d', strtotime($this->start_in)),
            'startDate_jalali' => Jalalian::forge($this['start_in'])->format('Y/m/d'),
            'travel_method' => config('defines.travelMethod')[$this->travel_method],
            'number_night' => $this->number_nights,
            'additional_services' => $this->additional_services,
            'rules' => $this->rules,
            'obligations' => $this->obligations,
            'imageUrl' => $this->when($this['imageThumb'], 'http://clicksafar.com/' . $this['imageThumb'], null),
            'capacity' => $this->capacity,
            'description' => $this->description,
            'vehicle_type' => $this->vehicle_type,
            'documents' => $this->documents,
            'indoors' => $this->indoors,
            'prices' => new PriceResource($this->pricesDesc),
            'agency' => new AgencyResource($this->agency),
            'levels' => $this->levels,
            'maps' => $this->maps,
            'images' => $this->images,
            'services' => $this->services,
            'destinations' => $this->justCities,
            'origin_name' => $this->city,
        ];
    }

    public function with($request)
    {

        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        return [
            'meta' => [
                'currency' =>
                [
                    'usd' => $getUsd,
                    'euro' => $getEuro,
                ]
            ]
        ];
    }
}
