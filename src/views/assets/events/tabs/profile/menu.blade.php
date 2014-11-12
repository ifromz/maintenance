
<a href="{{ route('maintenance.assets.events.edit', array($asset->id, $event->id)) }}" class="btn btn-app">
    <i class="fa fa-pencil"></i> Edit
</a>

<a 
    href="{{ route('maintenance.assets.events.destroy', array($asset->id, $event->id)) }}"
    data-method="DELETE"
    data-title="Are you sure?"
    data-message="Are you sure you want to delete this event? This will also remove all the recurrences of this event."
    class="btn btn-app"
    >
    <i class="fa fa-trash-o"></i> Delete
</a>