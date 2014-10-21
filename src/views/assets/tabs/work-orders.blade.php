@if($asset->workOrders->count() > 0) 
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Created At</th>
            <th>Attached On</th>
            <th>Attachments</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asset->workOrders as $workOrder)
        <tr>
            <td>{{ $workOrder->id }}</td>
            <td>{{ $workOrder->subject }}</td>
            <td>{{ $workOrder->created_at }}</td>
            <td>{{ $workOrder->pivot->created_at }}</td>
            <td>{{ $workOrder->attachments->count() }}</td>
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
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else

@endif