@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create a new Sub-{{ $resource }} for {{ $category->name }}
@stop

@section('panel.body.content')
    <script type="text/javascript" src="{{ asset('packages/stevebauman/maintenance/js/categories/create.js') }}"></script>

    {{
        Form::open(array(
        'url'=>action(currentControllerAction('store'), array($category->id)),
        'class'=>'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::categories.create', compact('category'))

    {{ Form::close() }}
@stop