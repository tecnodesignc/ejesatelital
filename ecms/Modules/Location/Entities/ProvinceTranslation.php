<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class ProvinceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'location__province_translations';
}
