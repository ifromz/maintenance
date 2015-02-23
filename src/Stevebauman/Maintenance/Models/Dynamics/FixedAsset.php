<?php

namespace Stevebauman\Maintenance\Models\Dynamics;

use Stevebauman\Inventory\Models\BaseModel;

class FixedAsset extends BaseModel
{

    protected $connection = 'dynamics';

    protected $table = 'dbo.FixedAssets';

}