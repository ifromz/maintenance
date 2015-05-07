<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Status.
 */
class Status extends BaseModel
{
    use HasUserTrait;

    protected $table = 'statuses';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\StatusViewer';

    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    /**
     * Returns an html label with the color of the status.
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
