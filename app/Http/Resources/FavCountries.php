<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FavCountries extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($items){

            return [
                'country_id'=>$items['origin'],
                'title'=>$items['title'],
                'details'=>str_replace('&nbsp;',' ',strip_tags($items['details'])),
                'imageUrl'=>'https://clicksafar.com/'.$items['image']
            ];

        });
    }
}
