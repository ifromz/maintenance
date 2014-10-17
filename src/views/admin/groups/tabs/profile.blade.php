
<a href="{{ route('maintenance.admin.groups.edit', array($group->id)) }}" class="btn btn-app">
    <i class="fa fa-edit"></i> Edit
</a>

<a href="{{ route('maintenance.admin.groups.destroy', array($group->id)) }}" 
   data-method="delete"
   data-title="Delete work order?"
   data-message="Are you sure you want to delete this group? Deleting this group may affect users access to funcionality on the website" 
   class="btn btn-app">
    <i class="fa fa-trash-o"></i> Delete
</a>

<hr>

<dl class="dl-horizontal">
    
    <dt>Name:</dt>
    <dd>{{ $group->name }}</dd>

    <p></p>
    
    <dt>Total Users:</dt>
    <dd>{{ $group->users->count() }}</dd>

    <p></p>
    
    <dt>Last Updated At:</dt>
    <dd>{{ $group->updated_at }}</dd>

    <p></p>
    
    <dt>Created At:</dt>
    <dd>{{ $group->created_at }}</dd>

    <p></p>
    
</dl>