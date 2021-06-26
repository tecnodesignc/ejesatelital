<?php

namespace Modules\Location\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Translatable;

    protected $table = 'location__cities';
    public $translatedAttributes = [
        'name'
    ];
    protected $fillable = [
        'name',
        'code',
        'province_id',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,"country_id","country_code");
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.city', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
