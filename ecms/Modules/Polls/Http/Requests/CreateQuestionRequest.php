<?php

namespace Modules\Polls\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateQuestionRequest extends BaseFormRequest
{
    public function rules()
    {
        return ['poll_id'=>'exists:polls__polls,id'];
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
