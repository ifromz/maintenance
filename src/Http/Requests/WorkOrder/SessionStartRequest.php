<?php

namespace Stevebauman\Maintenance\Http\Requests\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\Request as BaseRequest;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository;

class SessionStartRequest extends BaseRequest
{
    /**
     * The session start validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to start work order sessions
     * if they don't already have an open session.
     *
     * @param Repository $repository
     *
     * @return bool
     */
    public function authorize(Repository $repository)
    {
        $workOrderId = $this->route('work_orders');

        $session = $repository->findLastUserSession($workOrderId);

        if ($session && $session->out === null) {
            return false;
        } else {
            return true;
        }
    }
}
