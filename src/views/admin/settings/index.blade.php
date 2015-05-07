@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Settings
@stop

@section('panel.body.content')

    <a href="{{ route('maintenance.admin.settings.site.index') }}"
       class="btn btn-app no-print">
        <i class="fa fa-sitemap"></i> Site Settings
    </a>

    <a href="{{ route('maintenance.admin.settings.mail.index') }}"
       class="btn btn-app no-print">
        <i class="fa fa-envelope-o"></i> Mail Settings
    </a>

@stop
