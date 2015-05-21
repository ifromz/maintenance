{{
    Form::open([
        'url' => (isset($url) ? $url : route(currentRouteName(), Input::all())),
        'method' => 'GET',
        'class'=>'form-horizontal ajax-form-get',
        'data-refresh-target'=>'#resource-paginate'
    ])
}}

    <div class="input-group">
        <div class="input-group-addon"># Per Page</div>
        {{
            Form::select(
                'per_page',
                $amounts,
                (Input::has('per_page') && in_array(Input::get('per_page'), $amounts) ? Input::get('per_page') : '25'),
                ['class' => 'form-control', 'id' => 'records-per-page']
            )
        }}
        <span class="input-group-btn">
            {{ Form::submit('Go', ['class' => 'btn btn-primary']) }}
        </span>
    </div>

{{ Form::close() }}
