<?php

namespace Modules\Vehicle\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class BrandTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'name' => $this->when($this->board,$this->board),
            'status'=> $this->when($this->brand_id,$this->brand_id),
            'vehicles'=> VehicleTransformer::collection($this->whenLoaded('vehicles')),
            'created_at' => $this->when($this->created_at,$this->created_at),
            'updated_at' => $this->when($this->updated_at,$this->updated_at),
            'urls' => [
                'delete_url' => route('api.vehicle.bram.destroy', $this->id??'0'),
            ],
        ];


        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['name'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
            }
        }


        return $data;
    }
}
