<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Revision;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
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
     * Returns the revision user ID.
     *
     * @return int
     */
    public function revisionUserId()
    {
        return Sentry::getUser()->id;
    }
}
