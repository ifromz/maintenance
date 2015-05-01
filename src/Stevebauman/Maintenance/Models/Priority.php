<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

class Priority extends BaseModel
{
    use HasUserTrait;

    protected $table = 'priorities';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\PriorityViewer';

    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    /**
     * Returns a pretty label of the work order priority
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
     * Compatibility with Revisionable
     *
     * @return string
     */
    public function identifiableName()
    {
        return $this->name;
    }
}
