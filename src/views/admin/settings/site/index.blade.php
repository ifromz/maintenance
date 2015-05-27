@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Site Settings
@stop

@section('panel.body.content')
    {!!
       Form::open([
           'url' => route('maintenance.admin.settings.site.store'),
           'class' => 'form-horizontal ajax-form-post',
       ])
   }}

    <div class="form-group">
        <label class="col-sm-2 control-label">Main Site Title:</label>

        <div class="col-md-4">
            {!! Form::text('title', config('maintenance.site.title.main'), ['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Administrator Site Title:</label>

        <div class="col-md-4">
            {!! Form::text('admin_title', config('maintenance.site.title.admin'), ['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Work Order Calendar ID:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-calendar-o"></i>
                </div>

                {!! Form::text('work_order_calendar', config('maintenance,site.calendars.work-orders'), ['class'=>'form-control']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Inventory Calendar ID:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-calendar-o"></i>
                </div>

                {!! Form::text('inventory_calendar', config('maintenance.site.calendars.inventories'), ['class'=>'form-control']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Asset Calendar ID:</label>

        <div class="col-md-4">

            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-calendar-o"></i>
                </div>

                {!! Form::text('asset_calendar', config('maintenance.site.calendars.assets'), ['class'=>'form-control']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
