<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use App\Viewers\UpdateViewer;

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
        'content',
    ];
}
