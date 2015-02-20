<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Exceptions\WorkOrderNotFoundException;
use Stevebauman\Maintenance\Services\PriorityService;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class WorkOrderService
 * @package Stevebauman\Maintenance\Services\WorkOrder
 */
class WorkOrderService extends BaseModelService
{

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @param WorkOrder $workOrder
     * @param SentryService $sentry
     * @param PriorityService $priority
     * @param StatusService $status
     * @param WorkOrderNotFoundException $notFoundException
     */
    public function __construct(
        WorkOrder $workOrder,
        SentryService $sentry,
        PriorityService $priority,
        StatusService $status,
        WorkOrderNotFoundException $notFoundException
    )
    {
        $this->model = $workOrder;
        $this->sentry = $sentry;
        $this->priority = $priority;
        $this->status = $status;
        $this->notFoundException = $notFoundException;
    }

    /**
     * Returns an eloquent collection of all work orders with query scopes
     * for search functionality
     *
     * @param null $archived
     * @return mixed
     */
    public function getByPageWithFilter($archived = NULL)
    {
        return $this
            ->setPaginatedName('work-order-page')
            ->model
            ->with(array(
                'category',
                'user',
                'sessions',
            ))
            ->id($this->getInput('id'))
            ->priority($this->getInput('priority'))
            ->subject($this->getInput('subject'))
            ->assets($this->getInput('assets'))
            ->description($this->getInput('description'))
            ->status($this->getInput('status'))
            ->category($this->getInput('category_id'))
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->archived($archived)
            ->paginate(25);
    }

    /**
     * @return mixed
     */
    public function getUserAssignedWorkOrders()
    {
        return $this->model
            ->with(array(
                'status',
                'category',
                'user',
            ))
            ->assignedUser($this->sentry->getCurrentUserId())
            ->paginate(25);
    }

    /**
     * Creates a work order
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'category_id' => $this->getInput('category_id'),
                'location_id' => $this->getInput('location_id'),
                'status_id' => $this->getInput('status'),
                'priority_id' => $this->getInput('priority'),
                'subject' => $this->getInput('subject', NULL, true),
                'description' => $this->getInput('description', NULL, true),
                'started_at' => $this->getInput('started_at'),
                'completed_at' => $this->getInput('completed_at'),
            );

            $record = $this->model->create($insert);

            $assets = $this->getInput('assets');

            if ($assets) {
                $record->assets()->attach($assets);
            }

            $this->fireEvent('maintenance.work-orders.created', array(
                'workOrder' => $record
            ));

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    public function createFromWorkRequest($workRequest)
    {
        $this->dbStartTransaction();

        try {

            $status = $this
                ->status
                ->setInput(config('maintenance::rules.work-requests.submission_status'))
                ->firstOrCreate();

            $priority = $this
                ->priority
                ->setInput(config('maintenance::rules.work-requests.submission_priority'))
                ->firstOrCreate();

            $insert = array(
                'status_id' => $status->id,
                'priority_id' => $priority->id,
                'user_id' => $workRequest->user_id,
                'subject' => $workRequest->subject,
                'description' => $workRequest->description,
            );

            $workOrder = $this->model->create($insert);

            if($workOrder) {

                $this->dbCommitTransaction();

                return $workOrder;
            }

        } catch(\Exception $e) {

            $this->dbRollbackTransaction();

        }

        return false;
    }

    /**
     * Updates a work order
     *
     * @param int|string $id
     * @return bool|object
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $insert = array(
                'category_id' => $this->getInput('category_id', $record->category_id),
                'location_id' => $this->getInput('location_id', $record->location_id),
                'status_id' => $this->getInput('status', $record->status->id),
                'priority_id' => $this->getInput('priority', $record->priority->id),
                'subject' => $this->getInput('subject', $record->subject, true),
                'description' => $this->getInput('description', $record->description, true),
                'started_at' => $this->getInput('started_at', $record->started_at),
                'completed_at' => $this->getInput('completed_at', $record->completed_at),
            );

            if ($record->update($insert)) {

                $assets = $this->getInput('assets');

                if ($assets) {
                    $record->assets()->sync($assets);
                }

                $this->fireEvent('maintenance.work-orders.updated', array(
                    'workOrder' => $record
                ));

                $this->dbCommitTransaction();

                return $record;

            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }

    }

    /**
     * Deletes a work order
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $this->dbStartTransaction();

        try {

            $record = $this->find($id);

            $record->delete();

            $this->fireEvent('maintenance.work-orders.destroyed', array(
                'workOrder' => $record
            ));

            $this->dbCommitTransaction();

            return true;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Attaches a stock item to a work order as a 'part'
     *
     * @param object $workOrder
     * @param object $stock
     * @return boolean
     */
    public function savePart($workOrder, $stock)
    {

        $this->dbStartTransaction();

        try {
            /*
             * Find if the stock ('part') is already attached to the work order
             */
            $part = $workOrder->parts->find($stock->id);

            /*
             * If record exists
             */
            if ($part) {

                /*
                 * Add on the quantity inputted to the existing record quantity
                 */
                $newQuantity = $part->pivot->quantity + $this->getInput('quantity');

                /*
                 * Update the existing pivot record
                 */
                $workOrder->parts()->updateExistingPivot($part->id, array('quantity' => $newQuantity));

            } else {

                /*
                 * Part Record does not exist, attach a new record with quantity inputted
                 */
                $workOrder->parts()->attach($stock->id, array('quantity' => $this->getInput('quantity')));
            }

            /*
             * Fire the event for notifications
             */
            $this->fireEvent('maintenance.work-orders.parts.created', array(
                'workOrder' => $workOrder,
                'stock' => $stock,
            ));

            $this->dbCommitTransaction();

            return true;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Attaches a customer update to the work order pivot table
     *
     * @param object $workOrder
     * @param object $update
     * @return boolean
     */
    public function saveCustomerUpdate($workOrder, $update)
    {
        $this->dbStartTransaction();

        try {

            if ($workOrder->customerUpdates()->save($update)) {

                $this->fireEvent('maintenance.work-orders.updates.customer.created', array(
                    'workOrder' => $workOrder,
                    'update' => $update
                ));

                $this->dbCommitTransaction();

                return true;

            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Attaches a technician update to the work order pivot table
     *
     * @param object $workOrder
     * @param object $update
     * @return boolean
     */
    public function saveTechnicianUpdate($workOrder, $update)
    {
        $this->dbStartTransaction();

        try {

            if ($workOrder->technicianUpdates()->save($update)) {

                $this->fireEvent('maintenance.work-orders.updates.technician.created', array(
                    'workOrder' => $workOrder,
                    'update' => $update
                ));

                $this->dbCommitTransaction();

                return true;
            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

}