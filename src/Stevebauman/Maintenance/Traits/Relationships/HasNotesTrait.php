<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

trait HasNotesTrait
{
    /**
     * The morphToMany notes relationship allowing any model to contain notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function notes()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Note', 'noteable')->withTimestamps();
    }
}
