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
            <td>{{ renderNode($stock->location) }}</td>
            <td>{{ $stock->pivot->created_at }}</td>
            <td>
                {{ Form::open(array(
                            'url'=>route('maintenance.work-orders.parts.stocks.destroy', array($workOrder->id, $stock->item->id, $stock->id)), 
                            'class'=>'ajax-form-post',
                            'data-refresh-target'=>'#parts-table'
                        ))
                }}
                
                <button
                    type="submit" 
                    class="btn btn-primary confirm"
                    data-confirm-message="Are you sure you want to put back {{ $stock->pivot->quantity }} of {{ $stock->item->name }}?"
                    >
                    <i class="fa fa-reply"></i> Put Back
                </button>
                
                {{ Form::close() }}
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

@else
<h5>There are currently no parts attached to this work order.</h5>
@endif