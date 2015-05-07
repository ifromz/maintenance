<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\WorkOrder\NotificationService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;

/**
 * Class WorkOrderListener.
 */
class WorkOrderListener extends AbstractListener
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var NotificationService
     */
    protected $workOrderNotification;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param WorkOrderService    $workOrder
     * @param NotificationService $workOrderNotification
     * @param SentryService       $sentry
     * @param ConfigService       $config
     */
    public function __construct(
        WorkOrderService $workOrder,
        NotificationService $workOrderNotification,
        SentryService $sentry,
        ConfigService $config
    ) {
        $this->workOrder = $workOrder;
        $this->workOrderNotification = $workOrderNotification;
        $this->sentry = $sentry;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Subscribes to work order events for notifications.
     *
     * @param object $events
     */
    public function subscribe($events)
    {
        $events->listen('maintenance.work-orders.updates.technician.created',   'Stevebauman\Maintenance\Listeners\WorkOrderListener@onTechnicianUpdatesAdded');
        $events->listen('maintenance.work-orders.updates.customer.created',     'Stevebauman\Maintenance\Listeners\WorkOrderListener@onCustomerUpdatesAdded');
        $events->listen('maintenance.work-orders.parts.created',                'Stevebauman\Maintenance\Listeners\WorkOrderListener@onPartsAdded');
        $events->listen('maintenance.work-orders.reports.created',              'Stevebauman\Maintenance\Listeners\WorkOrderListener@onReportCreated');
    }

    /**
     * Notify's users if a part is added to a work order if they have it enabled.
     *
     * @param object $workOrder
     * @param object $stock
     */
    public function onPartsAdded($workOrder, $stock)
    {
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);

        if ($notifiableUsers->count() > 0) {
            foreach ($notifiableUsers as $notify) {
                if ($notify->parts) {
                    $this->createNotification(
                            $notify->user_id,
                            $workOrder,
                            'Parts have been added work order',
                            route('maintenance.work-orders.show', [$workOrder->id])
                    );
                }
            }
        }
    }

    /**
     * Notify's users if a customer update
     * is added to a work order if they have it enabled.
     *
     * @param object $workOrder
     */
    public function onCustomerUpdatesAdded($workOrder)
    {
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);

        if ($notifiableUsers->count() > 0) {
            foreach ($notifiableUsers as $notify) {
                if ($notify->customer_updates) {
                    $this->createNotification(
                            $notify->user_id,
                            $workOrder,
                            'Customer updates have been added to work order',
                            route('maintenance.work-orders.show', [$workOrder->id])
                    );
                }
            }
        }
    }

    /**
     * Notify's users if a technician update
     * is added to a work order if they have it enabled.
     *
     * @param object $workOrder
     */
    public function onTechnicianUpdatesAdded($workOrder)
    {
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);

        if ($notifiableUsers->count() > 0) {
            foreach ($notifiableUsers as $notify) {
                if ($notify->technician_updates) {
                    $this->createNotification(
                            $notify->user_id,
                            $workOrder,
                            'Technician updates have been added to work order',
                            route('maintenance.work-orders.show', [$workOrder->id])
                    );
                }
            }
        }
    }

    /**
     * Notify's users if a work order report
     * is created if they have it enabled.
     *
     * @param object $report
     */
    public function onReportCreated($report)
    {
        $notifiableUsers = $this->getNotifiableUsers($report->workOrder->id);

        if ($notifiableUsers->count() > 0) {
            foreach ($notifiableUsers as $notify) {
                if ($notify->completion_report) {
                    $this->createNotification(
                            $notify->user_id,
                            $report->workOrder,
                            'Parts have been added work order',
                            route('maintenance.work-orders.show', [$report->workOrder->id])
                    );
                }
            }
        }
    }

    /**
     * Returns an eloquent collection of notifiable users.
     *
     * @param int $workOrder_id
     */
    private function getNotifiableUsers($workOrder_id)
    {
        $query = $this->workOrderNotification->where('work_order_id', $workOrder_id);

        if ($this->config->get('rules.notifications.prevent_sending_to_source')) {
            /*
             * Returns notifiable users but removes the current user since
             * they are the ones who made the change
             */
            $query->where('user_id', '!=', $this->sentry->getCurrentUserId());
        }

        return $query->get();
    }
}
