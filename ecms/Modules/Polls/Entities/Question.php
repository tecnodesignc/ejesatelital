<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Translatable;

    protected $table = 'polls__questions';
    public $translatedAttributes = ['statement','description'];
    protected $fillable = ['statement','description','type_id','options'];






}
