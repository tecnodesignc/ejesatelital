<?php

namespace Modules\Company\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use Translatable;

    protected $table = 'company__accounttypes';
    public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'options'];

    public function children()
    {
        return $this->hasMany(Account::class, 'account_type_id');
    }
}
