<legend>Profile</legend>

@include('maintenance::work-orders.tabs.profile.menu', array(
    'workOrder'=>$workOrder
))

<div class="clearfix"></div>

<hr>

@include('maintenance::work-orders.tabs.profile.description', array(
    'workOrder'=>$workOrder
))

@include('maintenance::work-orders.modals.assignments.create', array(
    'workOrder'=>$workOrder
))

@include('maintenance::work-orders.modals.notifications', array(
    'workOrder'=>$workOrder
))