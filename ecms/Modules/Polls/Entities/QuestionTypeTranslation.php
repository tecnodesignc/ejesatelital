<?php

namespace Modules\Polls\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'polls__questiontype_translations';
}
