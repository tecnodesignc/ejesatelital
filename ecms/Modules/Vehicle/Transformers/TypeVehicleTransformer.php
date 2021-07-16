<?php

namespace Modules\Vehicle\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeVehicleTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'name' => $this->when($this->board,$this->board),
        ];

        return $data;
    }
}
