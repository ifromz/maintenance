<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use App\Viewers\StatusViewer;

class Status extends Model
{
    use HasUserTrait;

    /**
     * The statuses table.
     *
     * @var string
     */
    protected $table = 'statuses';

    /**
     * The status viewer.
     *
     * @var string
     */
    protected $viewer = StatusViewer::class;

    /**
     * The fillable status attributes.
     *
     * @var array
     */
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
