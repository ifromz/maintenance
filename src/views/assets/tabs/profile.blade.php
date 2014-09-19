<div class="col-md-12">
    @include('maintenance::assets.tabs.profile.menu', array('asset'=>$asset))
    
    <hr>
</div>

<div class="col-md-9">
    @include('maintenance::assets.tabs.profile.description', array('asset'=>$asset))
</div>

<div class="col-md-3">
    @include('maintenance::assets.tabs.profile.images', array('asset'=>$asset))
</div>


<div class="clearfix"></div>