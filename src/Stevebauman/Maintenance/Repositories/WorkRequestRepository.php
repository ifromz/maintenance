<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Models\WorkRequest;

class WorkRequestRepository extends Repository
{
    public function __construct()
    {

    }

    /**
     * @return WorkRequest
     */
    public function model()
    {
        return new WorkRequest();
    }
}
