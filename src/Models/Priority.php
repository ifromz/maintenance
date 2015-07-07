<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\PriorityViewer;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class Priority extends BaseModel
{
    use HasUserTrait;

    /**
     * The priorities table.
     *
     * @var string
     */
    protected $table = 'priorities';

    /**
     * The priority viewer.
     *
     * @var string
     */
    protected $viewer = PriorityViewer::class;

    /**
     * The fillable priority attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    /**
     * Returns a pretty label of the work order priority.
     *
     * @return string
     */
    public function getLabelAttribute()
    {
        return sprintf(
            '<span class="label label-%s">%s</span>',
            $this->attributes['color'],
            $this->attributes['name']
        );
    }

    /**
     * Compatibility with Revisionable.
     *
     * @return string
     */
    public function identifiableName()
    {
        return $this->name;
    }
}
