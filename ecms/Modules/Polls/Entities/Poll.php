<?php

namespace Modules\Polls\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\Entities\Account;

class Poll extends Model
{
    use Translatable;

    protected $table = 'polls__polls';
    public $translatedAttributes = ['title','slug', 'description'];
    protected $fillable = ['title','slug', 'description', 'options', 'active','account_id'];

    protected $casts=[
        'options' => 'array',
        'active'=>'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
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
        $config = implode('.', ['encore.polls.config.relations.poll', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }


}
