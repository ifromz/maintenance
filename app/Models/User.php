<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use Orchestra\Model\User as Eloquent;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Eloquent implements AuthorizableContract
{
    use Authorizable, AdldapUserModelTrait;
}
