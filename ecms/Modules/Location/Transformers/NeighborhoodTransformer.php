<?php

namespace Modules\Location\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class NeighborhoodTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name'=> $this->when($this->name,$this->name),
            'city_id'=> $this->when($this->city_id,$this->city_id),
            'province_id'=> $this->when($this->province_id,$this->province_id),
            'country_id'=> $this->when($this->country_id,$this->country_id),
            'city' => new CityTransformer($this->whenLoaded('city')),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
            'created_at' => $this->when($this->created_at, $this->created_at),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['name'] = $this->hasTranslation($lang) ? $this->translate("$lang")['name'] : '';
            }
        }

        return $data;
    }
}
