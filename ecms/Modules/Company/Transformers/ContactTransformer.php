<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Location\Transformers\CityTransformer;
use Modules\Location\Transformers\CountryTransformer;
use Modules\Location\Transformers\ProvinceTransformer;

class ContactTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' =>$this->when($this->id, $this->id),
            'first_name' => $this->when($this->first_name, $this->first_name),
            'last_name' => $this->when($this->last_name, $this->last_name),
            'email' => $this->when($this->email, $this->email),
            'phone' => $this->when($this->phone, $this->phone),
            'mobile'=>$this->when($this->mobile, $this->mobile),
            'street' => $this->when($this->street, $this->street),
            'city_id' => $this->when($this->city_id, $this->city_id),
            'province_id' => $this->when($this->province_id, $this->province_id),
            'country_id' => $this->when($this->country_id, $this->country_id),
            'account_id' => $this->when($this->account_id, $this->account_id),
            'options' => $this->when($this->options, $this->options),
            'account'=> new AccountTransformer($this->whenLoaded('account')),
            'country' => new CountryTransformer($this->whenLoaded('country')),
            'province' => new ProvinceTransformer($this->whenLoaded('province')),
            'city' => new CityTransformer($this->whenLoaded('city')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
            'urls' => [
                'deleteUrl' => route('api.company.contact.delete', $this->id),
            ]
        ];

      return $data;
    }
}
