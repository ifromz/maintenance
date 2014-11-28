@extends('maintenance::layouts.blocks.chat')

@section('chat.body.attributes') id="technician-updates-box" @overwrite

@section('chat.body.content')

    @foreach($workOrder->technicianUpdates as $update)
        {{ $update->viewer()->workOrderTechnician($workOrder) }}
    @endforeach
        
@overwrite
   
@section('chat.foot.content')
    
    {{ Form::open(array(
                'url'=>route('maintenance.work-orders.updates.technician.store', array($workOrder->id)), 
                'class'=>'ajax-form-post clear-form', 
                'data-refresh-target'=>'#technician-updates-box'
            ))
    }}
    <div class="input-group">
        <input name="update_content" class="form-control" placeholder="Type an update..."/>
        <div class="input-group-btn">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
        </div>    
    </div>
    {{ Form::close() }}

@overwrite