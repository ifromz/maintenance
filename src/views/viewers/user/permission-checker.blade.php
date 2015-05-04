<legend>Permission Checker</legend>

<div id="access-response"></div>

{{
    Form::open(array(
        'url'=>route('maintenance.admin.users.check-access', array($user->id)),
        'class'=>'form-horizontal ajax-form-post',
        'data-status-target'=>'#access-response'
    ))
}}


<div class="form-group">
    <label class="col-sm-2 control-label">Permission</label>

    <div class="col-md-4">
        {{ Form::text('permission', null, array('class'=>'form-control')) }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Check', array('class'=>'btn btn-primary')) }}
    </div>
</div>

{{ Form::close() }}

<div class="clearfix"></div>