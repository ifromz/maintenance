@extends('maintenance::layouts.blocks.message')

@section('message.body.content')

    <a href="#" class="name">
        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ $update->created_at }}</small>
        {{ $update->user->first_name }} {{ $update->user->last_name }}
    </a>

    {{ $update->content }}

@overwrite

@section('message.tools.content')

    @if(Sentry::getUser()->id === $update->user->id)
        <a
                data-method="delete"
                data-title="Delete message?"
                data-message="Are you sure you want to delete this message?"
                href="{{ route('maintenance.work-requests.updates.destroy', array($workRequest->id, $update->id)) }}">
            <i class="fa fa-trash-o"></i>
        </a>
    @endif

@overwrite
