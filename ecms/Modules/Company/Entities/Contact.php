<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Location\Entities\City;
use Modules\Location\Entities\Country;
use Modules\Location\Entities\Province;

class Contact extends Model
{

    protected $table = 'company__contacts';
    protected $fillable = ['first_name','last_name', 'email','phone','mobile','account_id','street','city_id', 'province_id', 'country_id','options'];
    protected static string $entityNamespace = 'encorecms/contact';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];

    /**
     *
     * RELATIONS
     *
     */

    public function account()
    {
        return $this->belongsTo(Account::class,'account_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class,'province_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
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
        $config = implode('.', ['ecore.company.config.relations.contact', $method]);

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
