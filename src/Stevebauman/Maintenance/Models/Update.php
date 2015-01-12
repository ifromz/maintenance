<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class Update extends BaseModel
{

    protected $table = 'updates';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\UpdateViewer';

    protected $fillable = array('user_id', 'content');

}