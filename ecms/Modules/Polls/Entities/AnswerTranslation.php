<?php

namespace Modules\Polls\Entities;

use Illuminate\Database\Eloquent\Model;

class AnswerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','caption'];
    protected $table = 'polls__answer_translations';
}
