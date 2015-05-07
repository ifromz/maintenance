@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Viewing Log Entry
@stop

@section('panel.body.content')

    <hr>

    <dl>
        <dt>Level:</dt>
        <dd>{{ ucfirst($entry->level) }}</dd>

        <p></p>

        <dt>Header:</dt>
        <dd>
            <pre>{{ $entry->header }}</pre>
        </dd>

        <p></p>

        <dt>Stack:</dt>
        <dd>
            @if(strlen($entry->stack) > 1)
                <pre>{{ $entry->stack }}</pre>
            @else
                <em>No stack trace to display</em>
            @endif
        </dd>

        <p></p>

    </dl>

@stop
