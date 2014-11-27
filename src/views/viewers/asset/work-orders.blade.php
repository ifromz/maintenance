<div id="resource-paginate">
    {{ $workOrders->columns(array(
                'id' => 'ID',
                'status' => 'Status',
                'priority' => 'Priority',
                'subject' => 'Subject',
                'description' => 'Description',
                'action' => 'Action'
            ))
            ->means('status', 'status.label')
            ->means('priority', 'priority.label')
            ->means('description', 'limited_description')
            ->modify('action', function($workOrder){
                return $workOrder->viewer()->btnActions;
            })
            ->showPages()
            ->render()
    }}
</div>