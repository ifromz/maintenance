<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\UpdateViewer;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class Update extends Model
{
    use HasUserTrait;

    /**
     * The updates table.
     *
     * @var string
     */
    protected $table = 'updates';

    /**
     * The update viewer.
     *
     * @var string
     */
    protected $viewer = UpdateViewer::class;

    /**
     * The fillable update attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content'
    ];
}
