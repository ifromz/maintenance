<table class="table table-striped">
        <thead>
        <tr>
            <th>{{ link_to_sort(currentRouteName(), 'ID', array('field'=>'id', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Status', array('field'=>'status_id', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Priority', array('field'=>'priority_id', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Subject', array('field'=>'subject', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Description', array('field'=>'description', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Category', array('field'=>'work_order_category_id', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Created By', array('field'=>'user', 'sort'=>'asc')) }}</th>
            <th>{{ link_to_sort(currentRouteName(), 'Created At', array('field'=>'created_at', 'sort'=>'asc')) }}</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="workOrder-body">
        @foreach($workOrders as $workOrder)
        <tr>
            <td>{{ $workOrder->id }}</td>
            <td>{{ $workOrder->status->label }}</td>
            <td>
                {{ $workOrder->priority->label }}
            </td>
            <td>{{ $workOrder->subject }}</td>
            <td>{{ str_limit($workOrder->description) }}</td>
            <td>
                {{ renderNode($workOrder->category) }}
            </td>
            <td>{{ $workOrder->user->full_name }}</td>
            <td>{{ $workOrder->created_at }}</td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('maintenance.work-orders.show', array($workOrder->id)) }}">
                                <i class="fa fa-search"></i> View Work Order
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.work-orders.edit', array($workOrder->id)) }}">
                                <i class="fa fa-edit"></i> Edit Work Order
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.work-orders.destroy', array($workOrder->id)) }}" data-method="delete" data-message="Are you sure you want to delete this work order? It will be archived.">
                                <i class="fa fa-trash-o"></i> Delete Work Order
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">{{ $workOrders->appends(Input::except('page'))->links() }}</div>