<div class="form-group">
    <label class="col-sm-2 control-label">Name</label>

    <div class="col-md-10">
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter a Name']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Reading</label>

    <div class="col-md-10">
        {!! Form::text('reading', null, ['class'=>'form-control', 'placeholder'=>'Enter the Current Reading']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Comment</label>

    <div class="col-md-10">
        {!! Form::text('comment', null, ['class'=>'form-control', 'placeholder'=> 'Enter a Comment']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Metric</label>

    <div class="col-md-10">
        @include('maintenance::select.metric')
    </div>
</div>
