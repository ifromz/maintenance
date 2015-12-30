@extends('maintenance::layouts.admin')

@section('title', 'Edit Role')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Edit Role {{ $role->name }}</h3>
            </div>

            <div class="panel-body">

                {!!
                    Form::open([
                        'url' => route('maintenance.admin.roles.update', [$role->id]),
                        'class' => 'form-horizontal',
                        'method' => 'PATCH'
                    ])
                !!}

                @include('maintenance::admin.roles.from', compact('role'))

                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop
