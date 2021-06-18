<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'company__contacts';
    protected $fillable = ['first_name','last_name', 'email','phone','mobile','street','city','state','country','options'];
}
