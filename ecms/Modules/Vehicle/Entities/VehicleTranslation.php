<?php

namespace Modules\Vehicle\Entities;

use Illuminate\Database\Eloquent\Model;

class VehicleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'vehicle__vehicle_translations';
}
