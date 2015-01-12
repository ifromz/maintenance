<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Group extends BaseModel
{

    protected $table = 'groups';

    protected $fillable = array('name', 'permissions');

    public function users()
    {
        return $this->belongsToMany('Stevebauman\Maintenance\Models\User', 'users_groups', 'group_id', 'user_id');
    }

}