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
            <td>{{ $workOrder->priority->label }}</td>
            <td>{{ $workOrder->subject }}</td>
            <td>{{ str_limit($workOrder->description) }}</td>
            <td>
                @if($workOrder->category)
                    {{ $workOrder->category->trail }}
                @endif
            </td>
            <td>{{ $workOrder->user->full_name }}</td>
            <td>{{ $workOrder->created_at }}</td>
            <td>
                {{ $workOrder->viewer()->btnActions }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>