<dl class="dl-horizontal">

    <dt>Tagged To:</dt>
    <dd>
        @foreach($event->assets as $asset)
        
            {{ $asset->viewer()->btnEventTag }}
        
        @endforeach
        
        @foreach($event->inventories as $item)
        
            {{ $item->viewer()->btnEventTag }}
        
        @endforeach
        
        @foreach($event->workOrders as $workOrder)
        
            {{ $workOrder->viewer()->btnEventTag }}
        
        @endforeach
    </dd>
    
</dl>
