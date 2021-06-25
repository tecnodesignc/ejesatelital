<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'city' => $this->when($this->city, $this->city),
            'state' => $this->when($this->state, $this->state),
            'country' => $this->when($this->country, $this->country),
            'options' => $this->when($this->options, $this->options),
            'contacts'=>AccountTransformer::collection($this->whenLoaded('contacts')),
            'links' => [
                'delete' => route('api.company.account.destroy', $this->resource->id),
                'edit' => route('api.company.account.edit', $this->resource->id),
            ]
        ];

      return $data;
    }
}
