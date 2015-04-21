@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Log Entries
@stop

@section('panel.body.content')
    {{
        $entries->columns(array(
            'level' => 'Level',
            'date' => 'Date',
            'header' => 'Header',
            'action' => 'Action'
        ))
        ->modify('level', function($entry)
        {
            return view('maintenance::viewers.log.labels.level', compact('entry'));
        })
        ->modify('header', function($entry)
        {
            return str_limit($entry->header, 150);
        })
        ->modify('action', function($entry)
        {
            return view('maintenance::viewers.log.buttons.actions', compact('entry'));
        })
        ->sortable(array(
            'level',
            'date',
        ))
        ->hidden(array(
            'header',
        ))
        ->showPages()
        ->render()
    }}
@stop