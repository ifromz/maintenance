<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Note;

trait HasNotesTrait
{
    /**
     * The morphToMany notes relationship allowing any model to contain notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
