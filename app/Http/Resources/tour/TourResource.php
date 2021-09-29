<?php

namespace App\Http\Resources\tour;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Morilog\Jalali\Jalalian;
use App\Http\Resources\tour\PriceResource;
use App\Http\Resources\tour\AgencyResource;


class TourResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'origin' => $item->origin,
                'start_in' => date('Y-m-d', strtotime($item->start_in)),
                'startDate_jalali' => Jalalian::forge($item['start_in'])->format('Y/m/d'),
                'travel_method' => $item->travel_method,
                'number_night' => $item->number_nights,
                'imageUrl' => $this->when($item['imageThumb'], url('/') . '/' . $item['imageThumb'], null),
                'capacity' => $item->capacity,
                'description' => $item->description,
                'travel_method' => $item->travel_method,
                'vehicle_type' => $item->vehicle_type,
                'documents' => $item->documents,
                'indoors' => $item->indoors,
                'prices' => new PriceResource($item->pricesDesc),
                'agency' => new AgencyResource($item->agency),
                'levels' => $item->levels,
                'maps' => $item->maps,
                'images' => $item->images,
                'services' => $item->services,
                'destinations' => $item->justCities,
                'origin_name' => $item->city,
                'minPrice'=>$item->minPrice
            ];
        });
    }


    public function with($request)
    {
        return [
            'meta' => [
                'travel_method_array' => ['aerial' => 'هوایی', 'earthy' => 'زمینی', 'marine' => 'دریایی']
            ]
        ];
    }
}
