{{ HTML::script('packages/stevebauman/maintenance/js/inventory/stocks/update.js') }}

<a href=""
   data-target="#create-stock-modal"
   data-toggle="modal"
   class="btn btn-app">
    <i class="fa fa-plus-circle"></i> Add Stock
</a>

<a href="{{ route('maintenance.inventory.edit', array($item->id)) }}"
    class="btn btn-app"
    >
    <i class="fa fa-pencil"></i> Edit Item
</a>

<a href="{{ route('maintenance.inventory.destroy', array($item->id)) }}"
   data-method="DELETE"
   data-title="Are you sure?"
   data-message="Are you sure you want to delete this item?"
    class="btn btn-app"
    >
    <i class="fa fa-trash-o"></i> Delete Item
</a>

<div class="clearfix"></div>

@include('maintenance::inventory.modals.stocks.create', array('item'=>$item))

<hr>

<div class="col-md-8">
    <dl class="dl-horizontal">
        @if($item->user)
        <dt>Created By:</dt>
        <dd>{{ $item->user->full_name }}</dd>

        <p></p>
        @endif

        <dt>Added:</dt>
        <dd>{{ $item->created_at }}</dd>

        <p></p>

        <dt>Name:</dt>
        <dd>{{ $item->name }}</dd>

        <p></p>
        
        <dt>Category:</dt>
        <dd>{{ renderNode($item->category) }}</dd>

        <p></p>

        <dt>Description:</dt>
        <dd class="pad bg-gray">{{ $item->description }}</dd>

        <p></p>
    </dl>
</div>

<div class="col-md-4">
    @include('maintenance::partials.qr', array(
        'content' => route('maintenance.inventory.show', array($item->id))
    ))
</div>

<div class="clearfix"></div>

<hr>

<h4>Current Stock by Location</h4>

<div id="inventory-stocks-table">
    @if($item->currentStock > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width='30'>Quantity</th>
                    <th>Location</th>
                    <th>Last Movement</th>
                    <th>Last Movement By</th>
                    <th>Update Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->stocks as $stock)
                <tr>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ renderNode($stock->location)}}</td>
                    <td>{{ $stock->lastMovement }}</td>
                    <td>{{ $stock->lastMovementBy }}</td>
                    <td>
                        <a 
                            href="{{ route('maintenance.api.inventory.stocks.edit', array($item->id, $stock->id)) }}"
                            class="btn btn-primary update-stock"
                            >
                            Update Stock
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @else
    <h5>There is currently no stock for this item.</h5>
    @endif
</div>