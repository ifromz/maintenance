<h4>Current Stock by Location</h4>

<div id="inventory-stocks-table">
    @if($item->stocks->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width='30'>Quantity</th>
                    <th>Location</th>
                    <th>Last Change</th>
                    <th>Last Change By</th>
                    <th>Action</th>
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
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a 
                                        href="{{ route('maintenance.api.inventory.stocks.edit', array($item->id, $stock->id)) }}"
                                        class="update-stock"
                                        >
                                        <i class="fa fa-refresh"></i> Update Stock
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('maintenance.inventory.stocks.movements.index', array($item->id, $stock->id)) }}">
                                        <i class="fa fa-search"></i> View Movements
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        href="{{ route('maintenance.inventory.stocks.destroy', array($item->id, $stock->id)) }}" 
                                        data-method="delete" 
                                        data-message="Are you sure you want to delete this stock and all of it's movements?">
                                        <i class="fa fa-trash-o"></i> Delete Stock
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
    <h5>There is currently no stock for this item.</h5>
    @endif
</div>