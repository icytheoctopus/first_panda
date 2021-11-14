<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'iso2' => $this->iso2,
            'iso3' => $this->iso3,
        ];
    }
}
