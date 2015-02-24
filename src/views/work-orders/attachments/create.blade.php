@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    {{
        Form::open(array(
            'url'=>route('maintenance.work-orders.attachments.store', array($workOrder->id)),
            'id'=>'upload-form',
            'data-upload-url'=>route('maintenance.work-orders.attachments.uploads.store'),
            'data-upload-ext'=>'doc,docx,xls,xlsx,ppt,txt,jpg,png,gif,pdf'
        ))
    }}

    <div id="current-container" class="form-group">
        {{ Form::button('Choose Files...', array('class'=>'btn btn-primary', 'id'=>'current-browse-button')) }}
        {{ Form::button('Upload Added Files', array('class'=>'btn btn-success', 'id'=>'current-start-upload')) }}
    </div>

    <div class="form-group">
        {{ Form::label('Files Added') }}
        <table id="added-table" class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>File Name</th>
                <th>File Size</th>
                <th>Progress</th>
                <th>Remove</th>
            </tr>
            </thead>
            <tbody id="added-list"></tbody>
        </table>

        {{ Form::label('Files Uploaded') }}
        <table id="uploaded-table" class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>File Name</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody id="uploaded-list">

            </tbody>
        </table>

    </div>

    <div class="form-group">
        <hr/>
    </div>

    <div class="form-group">
        {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
    </div>

    {{ HTML::script('packages/jildertmiedema/laravel-plupload/assets/js/plupload.full.min.js') }}
    {{ HTML::script('packages/stevebauman/maintenance/js/upload.js') }}

    </div>

@stop