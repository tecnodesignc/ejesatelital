<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class PolygonTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'name', 'description'];
    protected $table = 'location__polygon_translations';
}
