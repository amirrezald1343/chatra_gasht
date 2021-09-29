<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TourDetailsImages extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($item){

                return [
                    @'path'=>$this->when(@$item->media->path,@'https://clicksafar.com/'.@$item->media->path,null)
                ];

        });
    }
}
