<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\User;
use Stevebauman\Revision\Models\Revision;
use Stevebauman\Revision\Traits\HasRevisionsTrait as BaseRevisionTrait;

trait HasRevisionsTrait
{
    use BaseRevisionTrait;

    /**
     * The morphMany revisions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function revisions()
    {
        return $this->morphMany(Revision::class, 'revisionable');
    }

    /**
     * The hasOne revisionUser relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function revisionUser()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Returns the revision user ID.
     *
     * @return int
     */
    public function revisionUserId()
    {
        return $this->revisionUser->id;
    }
}
