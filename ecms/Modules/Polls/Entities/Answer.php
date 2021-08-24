<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Laracasts\Presenter\PresentableTrait;
use Modules\Polls\Presenters\QuestionPresenter;

class Answer extends Model
{
    use Translatable, MediaRelation, PresentableTrait;

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

    protected $presenter = QuestionPresenter::class;


    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * |--------------------------------------------------------------------------
     * | MUTATORS
     * |--------------------------------------------------------------------------
     */
    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }


    /**
     * Magic Method modification to allow dynamic relations to other entities.
     * @return string
     * @var $destination_path
     * @var $value
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['encore.polls.config.relations.answer', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}
