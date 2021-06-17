<?php

namespace Modules\Company\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use Translatable;

    protected $table = 'company__accounttypes';
    public $translatedAttributes = [];
    protected $fillable = [];
}
