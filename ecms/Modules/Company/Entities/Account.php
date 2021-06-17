<?php

namespace Modules\Company\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Account extends Model
{

    protected $table = 'company__accounts';
    protected $fillable = ['name', 'nit', 'account_site', 'parent', 'account_type_id', 'phone', 'street', 'city', 'state', 'country', 'options'];

    /**
     * |--------------------------------------------------------------------------
     * | RELATIONS
     * |--------------------------------------------------------------------------
     */

    public function AcountType()
    {
        return $this->belongsTo(AccountType::class,'account_type_id');
    }

    public function Contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function Users(){
        $this->belongsToMany(User::class,'company_account_user');
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
        $config = implode('.', ['ecore.blog.config.relations.category', $method]);

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
