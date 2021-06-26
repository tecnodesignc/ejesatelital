<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'name','full_name'];
    protected $table = 'location__country_translations';
}
