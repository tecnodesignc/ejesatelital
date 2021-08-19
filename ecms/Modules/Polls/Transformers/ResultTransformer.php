<?php

namespace Modules\Polls\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class ResultTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'question_id' => $this->when($this->question_id,$this->question_id),
            'answer_id' => $this->when($this->answer_id,$this->answer_id),
            'respond' => $this->respond??false,
            'account_id'=>$this->when($this->account_id,$this->account_id),
            'user_id' => $this->when($this->user_id,$this->user_id),
            'ip' => $this->when($this->ip,$this->ip),
            'fill' => $this->when($this->fill,$this->fill),
            'question'=> new QuestionTransformer($this->whenLoaded('question')),
            'answer'=> new AnswerTransformer($this->whenLoaded('answer')),
            'account'=> new AccountTransformer($this->whenLoaded('account')),
            'user'=> new UserTransformer($this->whenLoaded('user')),
            'created_at' => $this->when($this->created_at,$this->created_at),
            'updated_at' => $this->when($this->updated_at,$this->updated_at),
        ];


        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['statement'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['statement'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] : '';
            }
        }


        return $data;
    }
}
