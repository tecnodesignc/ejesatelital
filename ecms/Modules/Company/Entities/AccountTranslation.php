<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'company__account_translations';
}
