@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Edit Group {{ $group->name }}</h3>
            </div>

            <div class="panel-body">

                {!!
                    Form::open([
                        'url' => route('maintenance.admin.groups.update', [$group->id]),
                        'class' => 'form-horizontal ajax-form-post',
                        'method' => 'PATCH'
                    ])
                !!}

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>

                    <div class="col-md-4">
                        {!! Form::text('name', $group->name, ['class'=>'form-control', 'placeholder'=>'ex. Admininistrators']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Users</label>

                    <div class="col-md-4">
                        @include('maintenance::select.users', [
                            'users' => $group->users->lists('id', 'username')
                        ])
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Permissions</label>

                    <div class="col-md-4">
                        @include('maintenance::select.routes', [
                            'routes'=>$group->permissions
                        ])
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop
