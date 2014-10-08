@include('maintenance::inventory.tabs.profile.menu', array('item'=>$item))

<div class="clearfix"></div>

@include('maintenance::inventory.modals.stocks.create', array('item'=>$item))

<hr>

<div class="col-md-12">
    @include('maintenance::inventory.tabs.profile.description', array('item'=>$item))
</div>

<div class="clearfix"></div>

<hr>

@include('maintenance::inventory.tabs.profile.current-stock', array('item'=>$item))