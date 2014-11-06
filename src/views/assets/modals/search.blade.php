<div class="modal fade" id="search-modal" tabindex="-1 "role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(array('url'=>$url, 'method'=>'GET', 'class'=>'form-horizontal ajax-form-get', 'data-refresh-target'=>'#resource-paginate')) }}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Your Asset Results</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">ID</label>
                    <div class="col-md-10">
                        {{ Form::text(
                                    'id', 
                                    (Input::has('id') ? Input::get('id') : NULL),  
                                    array('class'=>'form-control', 'placeholder'=>'Enter Asset ID')
                                ) 
                        }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-10">
                        {{ Form::text(
                                    'name', 
                                    (Input::has('name') ? Input::get('name') : NULL),  
                                    array('class'=>'form-control', 'placeholder'=>'Enter Name')
                                ) 
                        }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Condition</label>
                    <div class="col-md-10">
                        {{ Form::select('condition', trans('maintenance::assets.conditions'), Input::get('condition') ?: NULL, array('class'=>'form-control select2')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-10">
                        @include('maintenance::select.asset-category', array(
                            'category' => (Input::has('category_name') ? Input::get('category_name') : NULL),
                            'category_id' => (Input::has('category_id') ? Input::get('category_id') : NULL)
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Location</label>
                    <div class="col-md-10">
                        @include('maintenance::select.location', array(
                            'location_name' => (Input::has('location_name') ? Input::get('location_name') : NULL),
                            'location_id' => (Input::has('location_id') ? Input::get('location_id') : NULL)
                        ))
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