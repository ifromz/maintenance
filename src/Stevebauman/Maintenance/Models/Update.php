<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Update
 * @package Stevebauman\Maintenance\Models
 */
class Update extends BaseModel
{
    use HasUserTrait;

    protected $table = 'updates';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\UpdateViewer';

    protected $fillable = ['user_id', 'content'];
}