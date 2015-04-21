@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Test
@stop

@section('panel.body.content')

    {{
        $entries->columns(array(
            'level' => 'Level',
            'header' => 'Header'
        ))->render()
    }}

    {{ $entries->links() }}
@stop