@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')

<li>
    <a href="{{ route('maintenance.assets.events.show', array($asset->id, $event->id)) }}">
        <i class="fa fa-search"></i> View Event
    </a>
</li>
<li>
    <a href="{{ route('maintenance.assets.events.edit', array($asset->id, $event->id)) }}">
        <i class="fa fa-edit"></i> Edit Event
    </a>
</li>
<li>
    <a 
        href="{{ route('maintenance.assets.events.destroy', array($asset->id, $event->id)) }}" 
        data-method="delete"
        data-title="Are you sure?"
        data-message="Are you sure you want to delete this event? Deleting this event will also remove all recurrences."
        >
        <i class="fa fa-trash-o"></i> Delete Event
    </a>
</li>

@overwrite