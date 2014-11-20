<legend>Parts / Supplies</legend>

<a href="{{ route('maintenance.work-orders.parts.index', array($workOrder->id)) }}" class="btn btn-app">
    <i class="fa fa-plus-circle"></i> Add Parts
</a>

@if($workOrder->parts->count() > 0)

<table id="parts-table" class="table table-striped">
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Item</th>
            <th>Quantity Taken</th>
            <th>Location Taken From</th>
            <th>Date Added</th>
            <th>Put Back</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workOrder->parts as $stock)

        <tr>
            <td>{{ $stock->item->id }}</td>
            <td>{{ $stock->item->name }}</td>
            <td>{{ $stock->pivot->quantity }}</td>
            <td>{{ $stock->location->trail }}</td>
            <td>{{ $stock->pivot->created_at }}</td>
            <td>
                
                <a class="btn btn-primary" data-toggle="modal" data-target="#put-back-items-modal-{{ $stock->item->id }}-{{ $stock->id }}">
                    <i class="fa fa-reply"></i> All
                </a>
                
                <a class="btn btn-primary" data-toggle="modal" data-target="#put-back-some-items-modal-{{ $stock->item->id }}-{{ $stock->id }}">
                    <i class="fa fa-reply"></i> Some
                </a>
                
                @include('maintenance::work-orders.modals.parts.put-back', array(
                    'workOrder' => $workOrder,
                    'item' => $stock->item,
                    'stock' => $stock
                ))
                
                @include('maintenance::work-orders.modals.parts.put-back-some', array(
                    'workOrder' => $workOrder,
                    'item' => $stock->item,
                    'stock' => $stock
                ))
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

@else
<h5>There are currently no parts attached to this work order.</h5>
@endif