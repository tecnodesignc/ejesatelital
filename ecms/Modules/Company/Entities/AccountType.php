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


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];


    public function accounts()
    {
        return $this->hasMany(Account::class, 'account_type_id');
    }
}
