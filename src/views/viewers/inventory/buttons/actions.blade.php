<div class="btn-group">
    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
        Action
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('maintenance.inventory.show', array($item->id)) }}">
                <i class="fa fa-search"></i> View Item
            </a>
        </li>
        <li>
            <a href="{{ route('maintenance.inventory.edit', array($item->id)) }}">
                <i class="fa fa-edit"></i> Edit Item
            </a>
        </li>
        <li>
            <a 
                href="{{ route('maintenance.inventory.destroy', array($item->id)) }}" 
                data-method="delete" 
                data-message="Are you sure you want to delete this item? It will be archived.">
                <i class="fa fa-trash-o"></i> Delete Item
            </a>
        </li>
    </ul>
</div>