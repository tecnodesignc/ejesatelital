<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'company__accounttype_translations';
}
