<?php

namespace Modules\Company\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Translatable;

    protected $table = 'company__contacts';
    public $translatedAttributes = [];
    protected $fillable = [];
}
