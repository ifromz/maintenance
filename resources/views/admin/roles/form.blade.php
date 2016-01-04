<div class="form-group{{ $errors->first('name', ' has-error') }}">
    <label class="col-sm-2 control-label">Name</label>

    <div class="col-md-4">
        {!! Form::text('name', (isset($role) ? $role->name : null), ['class'=>'form-control', 'placeholder'=>'ex. Workers']) !!}

        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('users', ' has-error') }}">
    <label class="col-sm-2 control-label">Members</label>

    <div class="col-md-4">
        @include('select.users', [
            'users' => (isset($role) ? $role->users->lists('id', 'username') : []),
        ])

        <span class="label label-danger">{{ $errors->first('users', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('routes', ' has-error') }}">
    <label class="col-sm-2 control-label">Permissions</label>

    <div class="col-md-4">
        @include('select.routes', [
            'routes' => (isset($role) ? $role->permissions : [])
        ])

        <span class="label label-danger">{{ $errors->first('routes', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>