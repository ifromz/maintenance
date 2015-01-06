<legend>Event Details</legend>

<div class="form-group">
    <label class="col-sm-2 control-label">Title / Summary</label>
    <div class="col-md-4">
        {{ Form::text('title', (isset($event) ? $event->title : NULL), array('class'=>'form-control', 'placeholder'=>'Enter Title')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Description</label>
    <div class="col-md-4">
        {{ Form::text('description', (isset($event) ? $event->description : NULL), array('class'=>'form-control', 'placeholder'=>'Enter Description')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Location</label>
    <div class="col-md-4">
        @include('maintenance::select.location')
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Start Date & Time</label>

    <div class="col-md-2">
        @include('maintenance::select.date', array(
            'name' => 'start_date',
            'value' => (isset($event) ? $event->viewer()->startDateFormatted : NULL)
        ))
    </div>

    <div class="col-md-2">
        @include('maintenance::select.time', array(
            'name' => 'start_time',
            'value' => (isset($event) ? $event->viewer()->startTimeFormatted : NULL)
        ))
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">End Date & Time</label>
    <div class="col-md-2">
        @include('maintenance::select.date', array(
            'name' => 'end_date',
            'value' => (isset($event) ? $event->viewer()->endDateFormatted : NULL)
        ))
    </div>
    <div class="col-md-2">
        @include('maintenance::select.time', array(
            'name' => 'end_time',
            'value' => (isset($event) ? $event->viewer()->endTimeFormatted : NULL)
        ))
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Attendees</label>
    <div class="col-md-4">
        @include('maintenance::select.users')
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">All Day</label>
    <div class="col-md-4">
        {{ Form::checkbox('all_day', 'true', (isset($event) ? $event->all_day : NULL), array('class'=>'form-control')) }}
    </div>
</div>

<legend>Recurrence Options</legend>

@if(isset($event))

    @if(!$event->isRecurrence)

        <div class="form-group">
            <div class="col-md-4 col-md-offset-2">
                <div class="alert alert-warning">
                    <p>
                        <b>Heads Up!</b> Setting a new frequency will change the dates and times of all events in the series.
                        If you've modified a recurrence, it's not recommended to change the recurrence options.
                    </p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Frequency</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_frequency', array(
                    'frequency' => $event->viewer()->recurFrequency
                ))
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Specific Days</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_days', array(
                    'days' => $event->viewer()->recurDays
                ))
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Secific Months</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_months')
            </div>
        </div>

    @endif

@else

    <div class="form-group">
        <label class="col-sm-2 control-label">Frequency</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_frequency')
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Specific Days</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_days')
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Secific Months</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_months')
        </div>
    </div>

@endif

<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>
