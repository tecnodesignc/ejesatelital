<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountTransformer extends JsonResource
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
            'city' => $this->when($this->city, $this->city),
            'state' => $this->when($this->state, $this->state),
            'country' => $this->when($this->country, $this->country),
            'options' => $this->when($this->options, $this->options),
            'account'=> new AccountTransformer($this->whenLoaded('account')),
            'urls' => [
                'deleteUrl' => route('api.company.contact.destroy', $this->resource->id),
            ]
        ];

      return $data;
    }
}
