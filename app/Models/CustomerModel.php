<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name', 'email','phone','country','comments','created_at','modified_on'
    ];
    public $timestamps = false;
}
