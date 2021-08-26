<?php

namespace Modules\Company\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Location\Entities\City;
use Modules\Location\Entities\Country;
use Modules\Location\Entities\Province;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\User\Entities\Sentinel\User;

class Account extends Model
{

    use MediaRelation, NamespacedEntity;

    protected $table = 'company__accounts';
    protected $fillable = ['name', 'nit', 'account_site', 'parent_id', 'active', 'account_type_id', 'phone', 'street', 'city_id', 'province_id', 'country_id', 'options'];
    protected static string $entityNamespace = 'encorecms/account';


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
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }
    public function Type()
    {
        return $this->belongsTo(AccountType::class,'account_type_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function users()
    {
       return $this->belongsToMany(User::class,'company__account_user')->with('roles');
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


    public function getLogoAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'logo')->first();
        if (!$thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/company/img/default.jpg')
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

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
        $config = implode('.', ['ecore.company.config.relations.account', $method]);

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
