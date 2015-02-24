@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    <script type="text/javascript"
            src="{{ asset('packages/stevebauman/maintenance/js/categories/create.js') }}"></script>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Sub-{{ $resource }} for {{ $category->name }}</h3>
            </div>
            <div class="panel-body">

                {{
                    Form::open(array(
                        'url'=>action(currentControllerAction('store'), array($category->id)), 
                        'class'=>'form-horizontal ajax-form-post clear-form'
                    )) 
                }}

                @include('maintenance::categories.create', compact('category'))

                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop