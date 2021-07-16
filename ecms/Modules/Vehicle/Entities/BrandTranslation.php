<?php

namespace Modules\Vehicle\Entities;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'vehicle__brand_translations';
}
