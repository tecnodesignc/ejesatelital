<?php

namespace Modules\Company\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Translatable;

    protected $table = 'company__accounts';
    public $translatedAttributes = [];
    protected $fillable = [];
}
