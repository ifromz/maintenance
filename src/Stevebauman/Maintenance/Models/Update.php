<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

class Update extends BaseModel
{

    use HasUserTrait;

    protected $table = 'updates';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\UpdateViewer';

    protected $fillable = array('user_id', 'content');

}