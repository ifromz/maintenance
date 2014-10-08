@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	
    {{ HTML::script('packages/stevebauman/maintenance/js/assets/edit.js') }}
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit asset</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url'=>route('maintenance.assets.events.update', array($asset->id, $event->id)), 'class'=>'form-horizontal ajax-form-post', 'method'=>'PATCH')) }}
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Title</label>
                    <div class="col-md-4">
                    	{{ Form::text('title', $event->title, array('class'=>'form-control', 'placeholder'=>'ex. Regular Maintenance')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Description</label>
                    <div class="col-md-4">
                    	{{ Form::textarea('description', $event->description, array('class'=>'form-control')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Start Date & Time</label>
                    <div class="col-md-2">
                    	{{ Form::text('start_date', $event->start_date, array('class'=>'form-control pickadate', 'placeholder'=>'Date')) }}
                    </div>
                    <div class="col-md-2">
                    	{{ Form::text('start_time', $event->start_time, array('class'=>'form-control pickatime', 'placeholder'=>'Time')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">End Date & Time</label>
                    <div class="col-md-2">
                    	{{ Form::text('end_date', $event->end_date, array('class'=>'form-control pickadate', 'placeholder'=>'Date')) }}
                    </div>
                    <div class="col-md-2">
                    	{{ Form::text('end_time', $event->end_time, array('class'=>'form-control pickatime', 'placeholder'=>'Time')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">All Day</label>
                    <div class="col-md-4">
                        {{ Form::checkbox('all_day', '1', $event->allDay, array('class'=>'form-control')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Color</label>
                    <div class="col-md-4">
                        @include('maintenance::select.color', array(
                            'name'=>'color',
                            'color' => $event->color
                        ))
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Background Color</label>
                    <div class="col-md-4">
                        @include('maintenance::select.color', array(
                            'name'=>'background_color',
                            'color' => $event->background_color
                        ))
                    </div>
                </div>
                
                <legend>Recur Options</legend>
                
                <div class="alert alert-info">
                    <h4>What do each of these options effect?</h4>
                    <dl>
                        
                        <dt>Frequency</dt>
                        <dd>
                            The frequency of the given event. For example: If an asset needs to be maintained weekly on the selected date, you would select 'Weekly'.
                        </dd>
                        
                        <p></p>
                        
                        <dt>Limit</dt>
                        <dd>
                            The limit input accepts a number which will limit the amount of recurrences of the event. 
                            For example: If you create a maintenance event that needs to happen every week, but only needs to be done 5 times. 
                            You would enter the number '5' in this case. If you're not sure how long this event needs to occur for, leave this blank.
                        </dd>
                        
                        <p></p>
                        
                        <dt>Specific Days</dt>
                        <dd>
                            The specific days you want the recurring event to be restricted to. 
                            For example: If an asset needs to be maintained daily, but only during the week, 
                            you would select all of the days of the week (Monday, Tuesday, Wednesday, Thursday, Friday)
                        </dd>
                        
                        <p></p>
                        
                        <dt>Specific Months</dt>
                        <dd>
                            The specific months you want the recurring event to be restricted to.
                            For example: If you need to regularly maintain an asset during the winter only, you would probably select November, December, January and February.
                        </dd>
                    </dl>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Frequency</label>
                    <div class="col-md-4">
                        @include('maintenance::select.recur_frequency', array(
                            'frequency' => $event->recur_frequency
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Limit</label>
                    <div class="col-md-4">
                        {{ Form::text('recur_limit', $event->recur_count, array('class'=>'form-control')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Specific Days</label>
                    <div class="col-md-4">
                        @include('maintenance::select.recur_days', array(
                            'days' => $event->recur_filter_days
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Secific Months</label>
                    <div class="col-md-4">
                        @include('maintenance::select.recur_months', array(
                            'months' => $event->recur_filter_months
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                    	{{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                    </div>
                </div>
                
                {{ Form::close() }}
            </div>
        </div>
    </div>
            
         
            
@stop