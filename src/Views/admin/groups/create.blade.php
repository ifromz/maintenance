@extends('maintenance::layouts.admin')

@section('title', 'Create Group')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Create Group</h3>
            </div>

            <div class="panel-body">

                {!!
                    Form::open([
                        'url' => route('maintenance.admin.groups.store'),
                        'class' => 'form-horizontal'
                    ])
                !!}

                @include('maintenance::admin.groups.form')

                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop
