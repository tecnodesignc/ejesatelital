<?php

namespace Modules\Vehicle\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;

    protected $table = 'vehicle__brands';
    public $translatedAttributes = ['name'];
    protected $fillable = ['name','status'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }


}
