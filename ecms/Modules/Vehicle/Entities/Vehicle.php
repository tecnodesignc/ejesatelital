<?php

namespace Modules\Vehicle\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use Translatable;

    protected $table = 'vehicle__vehicles';
    public $translatedAttributes = [];
    protected $fillable = [];
}
