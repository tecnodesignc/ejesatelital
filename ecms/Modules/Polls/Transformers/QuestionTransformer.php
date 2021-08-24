<?php

namespace Modules\Polls\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class QuestionTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'statement' => $this->when($this->statement,$this->statement),
            'description' => $this->when($this->description,$this->description),
            'options' => $this->when($this->options,$this->options),
            'poll_id' => $this->when($this->account_id,$this->account_id),
            'poll'=> new PollTransformer($this->whenLoaded('poll')),
            'answers'=> AnswerTransformer::collection($this->whenLoaded('answers')),
            'results'=> ResultTransformer::collection($this->whenLoaded('results')),
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
