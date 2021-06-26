<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class NeighborhoodTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ["name"];
    protected $table = 'location__neighborhood_translations';
}
