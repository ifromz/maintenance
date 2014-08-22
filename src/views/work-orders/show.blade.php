@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
    <script src="{{ asset('packages/stevebauman/maintenance/js/work-orders/show.js') }}"></script>
    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Work Order</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab">Details</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab">Parts</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab">QR Code</a></li>
                <li class="dropdown pull-right">
                	<a href="#" class="text-muted dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
                    <ul class="dropdown-menu">
                        <li role="presentation">
                        	<a role="menuitem" href="{{ route('maintenance.work-orders.edit', array($workOrder->id)) }}"><i class="fa fa-pencil"></i> Edit</a></li>
                        <li role="presentation">
                        	<a data-method="delete" data-message="Are you sure you want to delete this work order? This will also remove all updates." href="{{ route('maintenance.work-orders.destroy', array($workOrder->id)) }}" role="menuitem"><i class="fa fa-trash-o"></i> Delete</a>
                        </li>
                    </ul>
              	</li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <p><b>{{ $workOrder->subject }}</b></p>
                    <p>{{ $workOrder->description }}</p>
                   
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                   <table class="table">
                    	<tr>
                        	<th>Status:</th>
                            <td>{{ $workOrder->status->name }}</td>
                        </tr>
                        <tr>
                            <th>Created By:</th>
                            <td>{{ $workOrder->user->first_name }} {{ $workOrder->user->last_name }}</td>
                        </tr>
                        @if($workOrder->started_at)
                        <tr>
                     		<th>Started At:</th>
                            <td>{{ $workOrder->started_at }}</td>
                        </tr>
                        @endif
                        @if($workOrder->completed_at)
                        <tr>
                     		<th>Completed At:</th>
                            <td>{{ $workOrder->completed_at }}</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                
                </div>
                
                <div class="tab-pane" id="tab_4">
                	{{ DNS2D::getBarcodeSVG(route('maintenance.work-orders.show', array($workOrder->id)), "QRCODE") }}
                </div>
            </div><!-- /.tab-content -->
        </div>
        
        <!-- Chat box -->
        <div class="box box-success">
            <div class="box-header">
                <i class="fa fa-refresh"></i>
                <h3 class="box-title">Updates</h3>
            </div>
            <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                @foreach($workOrder->updates as $update)
                	@include('maintenance::partials.update', $update)
                @endforeach
            </div><!-- /.chat -->
            <div class="box-footer">
            {{ Form::open(array('url'=>route('maintenance.work-orders.updates.store', array($workOrder->id)), 'id'=>'work-order-update')) }}
                <div class="input-group">
                    <input name="update_content" class="form-control" placeholder="Type an update..."/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>    
                </div>
                {{ Form::close() }}
            </div>
        </div><!-- /.box (chat box) -->
    
    

@stop