<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Translatable;

    protected $table = 'polls__answers';
    public $translatedAttributes = [];
    protected $fillable = [];
}
