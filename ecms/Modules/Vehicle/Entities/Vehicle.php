<?php

namespace Modules\Vehicle\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Company\Entities\Account;
use Modules\User\Entities\Sentinel\User;
use Laracasts\Presenter\PresentableTrait;
use Modules\Vehicle\Presenters\VehiclePresenter;

class Vehicle extends Model
{

    use PresentableTrait;

    protected $table = 'vehicle__vehicles';
    protected $fillable = ['board','model','status','brand_id','type_vehicle','insurance_expiration','technomechanical_expiration','options'];

     protected $presenter = VehiclePresenter::class;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];

    public function drivers()
    {
        $driver = config('encore.user.config.driver');
        return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User",'vehicle__vehicle_driver')->withTimestamps();
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function accounts()
    {
        return $this->belongsToMany(Account::class,'vehicle__vehicle_account')->withTimestamps();
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
        $config = implode('.', ['encore.vehicle.config.relations.vehicle', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}
