@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Create Role</h3>
            </div>

            <div class="panel-body">

                {!!
                    Form::open([
                        'url' => route('maintenance.admin.roles.store'),
                        'class' => 'form-horizontal'
                    ])
                !!}

                @include('admin.roles.form')

                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop
