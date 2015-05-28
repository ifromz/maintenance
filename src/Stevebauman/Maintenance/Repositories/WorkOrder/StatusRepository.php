<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Models\Status;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class StatusRepository extends BaseRepository
{
    /**
     * @return Status
     */
    public function model()
    {
        return new Status();
    }

    /**
     * Creates or retrieves a default requested status.
     *
     * @return bool|Status
     */
    public function createDefaultRequested()
    {
        $status = $this->model()->firstOrCreate([
            'name' => 'Requested',
            'color' => 'default',
        ]);

        if($status) {
            return $status;
        }

        return false;
    }
}
