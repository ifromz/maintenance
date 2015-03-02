<?php

namespace Stevebauman\Maintenance\Models\Dynamics;

use Stevebauman\Maintenance\Models\BaseModel;

/**
 * Class FixedAsset
 * @package Stevebauman\Maintenance\Models\Dynamics
 */
class FixedAsset extends BaseModel
{
    protected $connection = 'dynamics';

    protected $table = 'dbo.FixedAssets';

    /**
     * The hasOne location relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Dynamics\Location', 'LOCATNID', 'Location ID');
    }
}