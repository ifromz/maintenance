@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        {{ Form::button('Choose Files...', array('class'=>'btn btn-primary', 'id'=>'current-browse-button')) }}
        {{ Form::button('Upload Added Files', array('class'=>'btn btn-success', 'id'=>'current-start-upload')) }}
    </div>
@stop

@section('panel.body.content')

    <div id="current-container">

        {{ Form::open(array(
                    'url'=>route('maintenance.assets.images.store', array($asset->id)),
                    'id'=>'upload-form',
                    'data-upload-url'=>route('maintenance.assets.images.uploads.store'),
                    'data-upload-ext'=>'jpg,png,gif',
                ))
        }}

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

    </div>
@stop

@section('panel.extra.bottom')
    {{ HTML::script('packages/jildertmiedema/laravel-plupload/assets/js/plupload.full.min.js') }}
    {{ HTML::script('packages/stevebauman/maintenance/js/upload.js') }}
@stop
