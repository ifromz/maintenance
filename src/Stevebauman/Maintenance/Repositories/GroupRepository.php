<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Models\Group;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class GroupRepository extends BaseRepository
{
    /**
     * @return Group
     */
    public function model()
    {
        return new Group();
    }

    public function create()
    {

    }

    public function update($id)
    {

    }
}
