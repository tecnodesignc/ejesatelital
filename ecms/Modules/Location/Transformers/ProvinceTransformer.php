<?php

namespace Modules\Location\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class ProvinceTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'iso2' => $this->when($this->iso_2, $this->iso_2),
            'calling_code' => $this->when($this->calling_code, $this->calling_code),
            'country_id' => $this->when($this->country_id, $this->country_id),
            'country' => new CountryTransformer($this->whenLoaded('country')),
            'cities' => CityTransformer::collection($this->whenLoaded('cities')),
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
