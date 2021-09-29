<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Morilog\Jalali\Jalalian;

class Packages extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return    $this->collection->map(function($items){
                  
             return [
                        'id'=>$items['id'],
                        'title'=>$items['title'],
                        'number_nights'=>$items['number_nights'],
                        'travel_method'=>$items['travel_method'],
                        'price'=>$items['minPrice'],
                        'origin'=>$items['title_fa'],
                        'agency_id'=>$items['agency_id'],
                        'agency_name'=>$items['agency_name'],
                        'startDate'=> Jalalian::forge($items['start_in'])->format('Y/m/d'),
                        'imageUrl'=>$this->when($items['imageThumb'],'https://clicksafar.com/'.$items['imageThumb'],'null')
                    ];
     
                    
                });               
    }
}
