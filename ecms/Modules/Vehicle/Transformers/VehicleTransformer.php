<?php

namespace Modules\Vehicle\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class VehicleTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'board' => $this->when($this->board,$this->board),
            'brand_id'=> $this->when($this->brand_id,$this->brand_id),
            'model'=> $this->when($this->model,$this->model),
            'type_vehicle_id'=> $this->when($this->type_vehicle,$this->type_vehicle),
            'type_vehicle'=> $this->when($this->type_vehicle,$this->presernt()->type_vehicle()),
            'insurance_expiration'=> $this->when($this->insurance_expiration,$this->insurance_expiration),
            'technomechanical_expiration'=> $this->when($this->insurance_expiration,$this->insurance_expiration),
            'company_id'=> $this->when($this->company_id,$this->company_id),
            'options'=> $this->when($this->options,$this->options),
            'drivers' => UserTransformer::collection($this->whenLoaded('drivers')),
            'company'=> new AccountTransformer($this->whenLoaded('company')),
            'created_at' => $this->when($this->created_at,$this->created_at),
            'updated_at' => $this->when($this->updated_at,$this->updated_at),

            'urls' => [
                'delete_url' => route('api.vehicle.vehicle.destroy', $this->id??'0'),
            ],
        ];

        return $data;
    }
}
