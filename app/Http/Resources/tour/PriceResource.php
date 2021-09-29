<?php

namespace App\Http\Resources\tour;

use Illuminate\Http\Resources\Json\ResourceCollection;



class PriceResource extends ResourceCollection
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
                'name' => $item->name,
                'type' => config('defines.hostType')[$item->type],
                'star' => $item->star,
                'price' => $item->price,
                'price_dollar' => $item->price_dollar,
                'baby' => $item->baby,
                'LTF' => $item->LTF,
                'BSF' => $item->BSF,
                'currency' => config('defines.currency')[$item['currency']],
            ];
        });
    }

}
