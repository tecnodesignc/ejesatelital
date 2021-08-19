<?php

namespace Modules\Polls\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\AccountTransformer;
use Modules\User\Transformers\UserTransformer;

class PollTransformer extends JsonResource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->when($this->id,$this->id),
            'title' => $this->when($this->title,$this->title),
            'slug' => $this->when($this->slug,$this->slug),
            'description' => $this->when($this->description,$this->description),
            'options' => $this->when($this->options,$this->options),
            'account_id' => $this->when($this->account_id,$this->account_id),
            'status'=> boolval($this->active),
            'account'=> new AccountTransformer($this->whenLoaded('account')),
            'questions'=> QuestionTransformer::collection($this->whenLoaded('questions')),
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
                $data[$lang]['slug'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['slug'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] : '';

            }
        }


        return $data;
    }
}
