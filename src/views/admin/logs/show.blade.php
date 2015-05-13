@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Viewing Log Entry
@stop

@section('panel.body.content')

    <a href="{{ route('maintenance.admin.logs.mark-read', [$entry->id]) }}"
       data-method="POST"
       data-title="Are you sure?"
       data-message="Are you sure you want to mark this entry as read?"
       class="btn btn-app no-print"
            >
        <i class="fa fa-eye"></i> Mark Read
    </a>

    <a href="{{ route('maintenance.admin.logs.destroy', [$entry->id]) }}"
       data-method="DELETE"
       data-title="Are you sure?"
       data-message="Are you sure you want to delete this log entry? It cannot be recovered."
       class="btn btn-app no-print"
            >
        <i class="fa fa-trash-o"></i> Delete
    </a>

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
