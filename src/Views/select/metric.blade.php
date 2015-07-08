<div class="input-group" id="metric-select">

    {!! Form::select('metric', $allMetrics, (isset($metric) ? $metric : null), ['class'=>'form-control']) !!}

    <span class="input-group-btn">
    	<button class="btn btn-primary" data-toggle="modal" data-target="#create-metric-modal" type="button">Create
        </button>
    </span>
</div>
