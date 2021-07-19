<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use Translatable;

    protected $table = 'polls__questiontypes';
    public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'options'];
}
