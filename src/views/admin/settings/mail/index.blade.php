@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Mail Settings
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.admin.settings.mail.store'),
            'class'=>'form-horizontal ajax-form-post',
        ))
    }}

    <div class="form-group">
        <label class="col-sm-2 control-label">Mail Driver:</label>

        <div class="col-md-4">
            @include('maintenance::select.mail-driver', array(
                'driver' => config('mail.driver')
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">SMTP Username:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                </div>

                {{ Form::text('smtp_username', config('mail.username'), array('class'=>'form-control')) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">SMTP Password:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-key"></i>
                </div>

                {{ Form::password('smtp_password', array('class'=>'form-control')) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Host IP Address:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-laptop"></i>
                </div>

                {{ Form::text('host_ip', config('mail.host'), array('class'=>'form-control', 'maxlength'=>'45')) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Port:</label>

        <div class="col-md-1">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-ellipsis-v"></i>
                </div>

                {{ Form::text('host_port', config('mail.port'), array('class'=>'form-control', 'maxlength' => '5')) }}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Global From:</label>

        <div class="col-md-2">

            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-envelope-o"></i> E-Mail
                </div>

                {{ Form::email('global_email', config('mail.from.address'), array('class'=>'form-control')) }}
            </div>

        </div>

        <div class="col-md-2">

            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-user"></i> Name
                </div>

                {{ Form::text('global_name', config('mail.from.name'), array('class'=>'form-control')) }}
            </div>

        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Encryption:</label>

        <div class="col-md-2">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </div>

                {{ Form::text('encryption', config('mail.encryption'), array('class'=>'form-control')) }}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Pretend Sending Mail?:</label>

        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    {{ Form::checkbox('pretend', 'true', config('mail.pretend')) }}
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
        </div>
    </div>

    {{ Form::close() }}
@stop