@extends('maintenance::layouts.admin')

@section('title', 'Edit Group')

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

                @include('maintenance::admin.groups.from', compact('group'))

                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop
