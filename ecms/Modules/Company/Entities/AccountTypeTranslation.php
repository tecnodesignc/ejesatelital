<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'company__accounttype_translations';
}
