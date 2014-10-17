<a 
    href="{{ route('maintenance.admin.users.edit', array($user->id)) }}" 
    class="btn btn-app"
    >
    <i class="fa fa-pencil-square-o"></i> Edit
</a>

<a href="{{ route('maintenance.admin.users.destroy', array($user->id)) }}" 
   data-method="delete"
   data-title="Delete this user?"
   data-message="Are you sure you want to delete this user? This can have a large cascade effect if the user is attached to certain data." 
   class="btn btn-app">
    <i class="fa fa-trash-o"></i> Delete
</a>

<hr>

<dl class="dl-horizontal">
    
    <dt>ID</dt>
    <dd>{{ $user->id }}</dd>
    <p></p>
    
    <dt>Username</dt>
    <dd>{{ $user->username }}</dd>
    <p></p>
    
    <dt>Email</dt>
    <dd>{{ $user->email }}</dd>
    <p></p>
    
    <dt>Name</dt>
    <dd>{{ $user->full_name }}</dd>
    <p></p>
    
    <dt>Created At</dt>
    <dd>{{ $user->created_at }}</dd>
    <p></p>
    
    @if($user->last_login)
    <dt>Last Login</dt>
    <dd>{{ $user->last_login }}</dd>
    <p></p>
    @endif
    
    @if($user->permissions)
    <dt>Permissions</dt>
    <dd>
        <ul class="list-unstyled">
            @foreach($user->permissions as $name=>$value)
            <li>{{ $name }} {{ $value }}</li>
            @endforeach
        </ul>
    </dd>
    <p></p>
    @endif
    
    @if($user->groups->count() > 0)
    <dt>Groups</dt>
    <dd>
        <ul class="list-unstyled">
            @foreach($user->groups as $group)
            <li><a href="{{ route('maintenance.admin.groups.show', array($group->id)) }}" class="label label-default">{{ $group->name }}</a></li>
            @endforeach
        </ul>
    </dd>
    <p></p>
    <br>
    @endif
</dl>

<legend>Permission Checker</legend>

<div id="access-response"></div>

{{ Form::open(array(
        'url'=>route('maintenance.admin.users.check-access', array($user->id)), 
        'class'=>'form-horizontal ajax-form-post',
        'data-status-target'=>'#access-response'
    )) 
}}

    
    <div class="form-group">
        <label class="col-sm-2 control-label">Permission</label>
        <div class="col-md-4">
            {{ Form::text('permission', NULL, array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Check', array('class'=>'btn btn-primary')) }}
        </div>
    </div>

{{ Form::close() }}

<div class="clearfix"></div>