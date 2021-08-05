<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Location\Transformers\CityTransformer;
use Modules\Location\Transformers\CountryTransformer;
use Modules\Location\Transformers\ProvinceTransformer;
use Modules\User\Transformers\News\UserTransformer;

class AccountTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' =>$this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'nit' => $this->when($this->nit, $this->nit),
            'accountSite' => $this->when($this->account_site, $this->account_site),
            'parent' => $this->when($this->parent, $this->parent),
            'accountTypeId'=>$this->when($this->account_type_id, $this->account_type_id),
            'phone' => $this->when($this->phone, $this->phone),
            'street' => $this->when($this->street, $this->street),
            'city_id' => $this->when($this->city_id, $this->city_id),
            'province_id' => $this->when($this->province_id, $this->province_id),
            'country_id' => $this->when($this->country_id, $this->country_id),
            'options' => $this->when($this->options, $this->options),
            'contacts'=>AccountTransformer::collection($this->whenLoaded('contacts')),
            'users'=>UserTransformer::collection($this->whenLoaded('users')),
            'type'=> new AccountTypeTransformer($this->whenLoaded('type')),
            'country' => new CountryTransformer($this->whenLoaded('country')),
            'province' => new ProvinceTransformer($this->whenLoaded('province')),
            'city' => new CityTransformer($this->whenLoaded('city')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
            'links' => [
                'delete' => route('api.company.account.destroy', $this->resource->id),
                'edit' => route('api.company.account.edit', $this->resource->id),
            ]
        ];

      return $data;
    }
}
