<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'company__contact_translations';
}
