<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class AccountTypeTransformer extends JsonResource
{


   public function toArray($request)
   {
      $data = [
         'id' => $this->when($this->id, $this->id),
         'name' => $this->when($this->name, $this->name),
         'options' => $this->when($this->options, $this->options),
         'accounts' => AccountTransformer::collection($this->whenLoaded('accounts')),
      ];

      $filter = json_decode($request->filter);

      // Return data with available translations
      if (isset($filter->allTranslations) && $filter->allTranslations) {
         // Get langs avaliables
         $languages = \LaravelLocalization::getSupportedLocales();

         foreach ($languages as $lang => $value) {
            $data[$lang]['name'] = $this->hasTranslation($lang) ?
               $this->translate("$lang")['name'] : '';
         }
      }

      return $data;
   }
}
