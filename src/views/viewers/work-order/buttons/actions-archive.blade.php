@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')
<li>
    <a href="{{ route('maintenance.admin.archive.work-orders.restore', array($workOrder->id)) }}"
       data-method="POST"
       data-message="Are you sure you want to restore this asset?">
        <i class="fa fa-refresh"></i> Restore
    </a>
</li>
<li class="divider"></li>
<li>
    <a href="{{ route('maintenance.admin.archive.work-orders.show', array($workOrder->id)) }}">
        <i class="fa fa-search"></i> View
    </a>
</li>
<li>
    <a href="{{ route('maintenance.admin.archive.work-orders.destroy', array($workOrder->id)) }}"
       data-method="delete"
       data-message="Are you sure you want to permanently delete this work order? You will not be able to recover this data.">
        <i class="fa fa-trash-o"></i> Delete (Permanent)
    </a>
</li>
@overwrite