<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Translatable;

    protected $table = 'polls__answers';
    public $translatedAttributes = ['title','caption'];
    protected $fillable = ['title','caption','type', 'question_id','options'];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];


    public function question()
    {
        return $this->belongsTo(Question::class);
    }



}
