<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Post extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $guarded = [];
}