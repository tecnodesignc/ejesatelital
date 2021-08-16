<?php

namespace Modules\Vehicle\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateVehicleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            //'board' => 'required|unique:vehicle__vehicles,board,'.$this->id,
            'brand_id' => 'required|exists:vehicle__brands,id',
            'accounts'=>'exists:company__accounts,id',
            'drivers'=>'exists:users,id'
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
