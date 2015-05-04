<legend>Event Report</legend>

<div id="event-report">

    @if($event->report)

        <dl class="dl-horizontal">

            <dt>Created By:</dt>
            <dd>{{ $event->report->user->fullname }}</dd>

            <p></p>

            <dt>Created On:</dt>
            <dd>{{ $event->report->created_at }}</dd>

            <p></p>

            <dt>Report:</dt>
            <dd class="bg-gray">
                {{ $event->report->description }}
            </dd>

        </dl>

    @else
        {{
            Form::open(array(
                    'url'=>route('maintenance.events.report.store', array($event->id)),
                    'data-refresh-target' => '#event-report',
                    'class'=>'form-horizontal ajax-form-post clear-form'
            ))
        }}

        <div class="form-group">
            <div class="col-md-offset-2 col-md-6">
                <div class="alert alert-info">
                    <p>No report has been filled out for this event yet. Enter the details below to create one.</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Description / Details</label>

            <div class="col-md-6">
                {{ Form::textarea('description', null, array('class'=>'form-control', 'style'=>'min-width:100%')) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
            </div>
        </div>

        {{ Form::close() }}
    @endif

</div>