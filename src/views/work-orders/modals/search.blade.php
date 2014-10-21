<div class="modal fade" id="search-modal" tabindex="-1 "role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(array('url'=>$url, 'method'=>'GET', 'class'=>'form-horizontal ajax-form-get', 'data-refresh-target'=>'#resource-paginate',)) }}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Your Work Order Results</h4>
            </div>
            <div class="modal-body">
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Subject</label>
                        <div class="col-md-10">
                            {{ Form::text(
                                        'subject', 
                                        (Input::has('subject') ? Input::get('subject') : NULL),  
                                        array('class'=>'form-control', 'placeholder'=>'Enter Subject')
                                    ) 
                            }}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-md-10">
                            {{ Form::text(
                                        'description', 
                                        (Input::has('description') ? Input::get('description') : NULL),  
                                        array('class'=>'form-control', 'placeholder'=>'Enter Description')
                                    ) 
                            }}
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Priority</label>
                        <div class="col-md-10">
                            @include('maintenance::select.priority', array(
                                'priority' => (Input::has('priority') ? Input::get('priority') : NULL)
                            ))
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-md-10">
                            @include('maintenance::select.status', array(
                                'status' => (Input::has('status') ? Input::get('status') : NULL)
                            ))
                        </div>
                    </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-10">
                        @include('maintenance::select.work-order-category', array(
                            'category_name' => (Input::has('work_order_category') ? Input::get('work_order_category') : NULL),
                            'category_id' => (Input::has('work_order_category_id') ? Input::get('work_order_category_id') : NULL)
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Assets Included</label>
                    <div class="col-md-10">
                        @include('maintenance::select.assets', array(
                            'assets' => (Input::has('assets') ? Input::get('assets') : NULL),
                        ))
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="{{ route('maintenance.work-orders.index') }}" class="btn btn-info">Reset Filter</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search-plus"></i> Search</button>
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
</div>