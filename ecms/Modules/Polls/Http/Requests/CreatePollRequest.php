<?php

namespace Modules\Polls\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePollRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            //'account_id'=>'exists:company__accounts,id',
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
