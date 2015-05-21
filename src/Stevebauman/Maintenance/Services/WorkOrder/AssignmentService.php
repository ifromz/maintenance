<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder\WorkOrderAssignmentNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;
use Stevebauman\Maintenance\Models\WorkOrderAssignment;

/**
 * Class AssignmentService.
 */
class AssignmentService extends BaseModelService
{
    /**
     * @var WorkOrderAssignment
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param WorkOrderAssignment                  $assignment
     * @param SentryService                        $sentry
     * @param WorkOrderAssignmentNotFoundException $notFoundException
     */
    public function __construct(WorkOrderAssignment $assignment, SentryService $sentry, WorkOrderAssignmentNotFoundException $notFoundException)
    {
        $this->model = $assignment;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }

    /**
     * @return array|bool
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $users = $this->getInput('users');

            if ($users) {
                $records = [];

                foreach ($users as $user) {
                    $insert = [
                        'work_order_id' => $this->getInput('work_order_id'),
                        'by_user_id' => $this->sentry->getCurrentUserId(),
                        'to_user_id' => $user,
                    ];

                    $records[] = $this->model->create($insert);
                }

                $this->dbCommitTransaction();

                return $records;
            }

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
