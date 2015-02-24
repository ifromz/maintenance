@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit {{ $resource }} {{ $category->name }}</h3>
            </div>
            <div class="panel-body">

                {{
                    Form::open(array(
                        'url'=>action(currentControllerAction('update'), array($category->id)),
                        'class'=>'form-horizontal ajax-form-post',
                        'method' => 'PATCH',
                    )) 
                }}

                @include('maintenance::categories.form', compact('category'))

                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop