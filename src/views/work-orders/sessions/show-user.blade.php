@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Work Order Sessions for User: {{ $user->full_name }}
@stop

@section('panel.body.content')

    @if($sessions->count() > 0)

        {{
            $sessions->columns([
                    'in' => 'In',
                    'out' => 'Out',
                    'hours' => 'Hours'
                ])
                ->sortable(['in', 'out'])
                ->showPages()
                ->render()
        }}

    @else
        <h5>There are no sessions to display for this user.</h5>
    @endif

@stop
