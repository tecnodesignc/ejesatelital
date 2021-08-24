<?php

namespace Modules\Polls\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class AnswerTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'title' => $this->when($this->title,$this->title),
            'caption' => $this->when($this->slug,$this->slug),
            'type_id' => $this->when($this->type,$this->type),
            'type'=>$this->present()->type_question(),
            'options' => $this->when($this->options,$this->options),
            'question_id' => $this->when($this->account_id,$this->account_id),
            'question'=> new QuestionTransformer($this->whenLoaded('question')),
            'results'=> ResultTransformer::collection($this->whenLoaded('results')),
            //'results_count'=>$this->present()->result_count(),
            'created_at' => $this->when($this->created_at,$this->created_at),
            'updated_at' => $this->when($this->updated_at,$this->updated_at),
        ];


        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['caption'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['caption'] : '';
            }
        }


        return $data;
    }
}
