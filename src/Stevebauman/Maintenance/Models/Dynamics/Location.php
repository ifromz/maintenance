<?php

namespace Stevebauman\Maintenance\Models\Dynamics;

use Stevebauman\Maintenance\Models\BaseModel;

class Location extends BaseModel
{
    protected $connection = 'dynamics';

    protected $table = 'dbo.FA41100';
}
