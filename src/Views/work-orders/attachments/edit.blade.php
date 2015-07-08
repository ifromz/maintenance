@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Attachment')

@section('panel.head.content')
Edit Attachment
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.attachments.update', [$workOrder->id, $attachment->id]),
            'class' => 'form-horizontal',
            'method' => 'PATCH',
        ])
    !!}

    @include('maintenance::work-orders.attachments.form', compact('attachment'))

    {!! Form::close() !!}

@stop
