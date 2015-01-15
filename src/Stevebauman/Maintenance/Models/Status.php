<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

class Status extends BaseModel
{

    use HasUserTrait;

    protected $table = 'statuses';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\StatusViewer';

    protected $fillable = array(
        'user_id',
        'name',
        'color'
    );

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