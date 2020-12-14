<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'username', 'password', 'email', 'age', 'biography', 'personal_photo'];
}
