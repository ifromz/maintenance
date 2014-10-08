
<div class="col-md-12">
    @include('maintenance::assets.events.tabs.profile.menu', array(
        'asset' => $asset,
        'event' => $event
    ))
    
    <hr>
</div>



<div class="col-md-12">
    @include('maintenance::assets.events.tabs.profile.description', array(
        'asset' => $asset,
        'event' => $event
    ))
</div>

<div class="clearfix"></div>