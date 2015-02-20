<div class="modal fade" id="search-modal" tabindex="-1 " role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(array('url'=>$url, 'method'=>'GET', 'class'=>'form-horizontal ajax-form-get', 'data-refresh-target'=>'#resource-paginate')) }}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Your User Results</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label">ID</label>

                    <div class="col-md-10">
                        {{
                            Form::text(
                                    'id',
                                    (Input::has('id') ? Input::get('id') : NULL),
                                    array('class'=>'form-control', 'placeholder'=>'Enter User ID')
                                )
                        }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>

                    <div class="col-md-10">
                        {{
                            Form::text(
                                    'name',
                                    (Input::has('name') ? Input::get('name') : NULL),
                                    array('class'=>'form-control', 'placeholder'=>'Enter Name')
                                )
                        }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>

                    <div class="col-md-10">
                        {{
                            Form::text(
                                    'username',
                                    (Input::has('username') ? Input::get('username') : NULL),
                                    array('class'=>'form-control', 'placeholder'=>'Enter Username')
                                )
                        }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>

                    <div class="col-md-10">
                        {{
                            Form::text(
                                    'email',
                                    (Input::has('email') ? Input::get('email') : NULL),
                                    array('class'=>'form-control', 'placeholder'=>'Enter Email')
                                )
                        }}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="{{ $url }}" class="btn btn-info">Reset Filter</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search-plus"></i> Search</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>