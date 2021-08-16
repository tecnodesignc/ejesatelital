<?php

namespace Modules\Vehicle\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateBrandRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return ['name' => "required|unique:vehicle__brand_translations,name,{$this->id}",];
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
