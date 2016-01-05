<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use App\Viewers\PriorityViewer;

class Priority extends Model
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
     * Finds or creates the default requested priority.
     *
     * @return Priority
     */
    public static function findOrCreateRequested()
    {
        return (new static())->firstOrCreate([
            'name'  => 'Requested',
            'color' => 'default',
        ]);
    }

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
