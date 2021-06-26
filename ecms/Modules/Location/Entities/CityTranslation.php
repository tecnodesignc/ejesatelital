<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'name'];
    protected $table = 'location__city_translations';
}
