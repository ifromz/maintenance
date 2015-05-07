@if($currentStock > 0)
    <span class="label label-success">{{ $currentStock }} In Stock</span>
@else
    <span class="label label-danger">No Stock</span>
@endif
