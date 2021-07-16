<?php

namespace Modules\Polls\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'polls__question_translations';
}
