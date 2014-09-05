@if($update)
<div class="item">
    <img src="{{ asset('packages/stevebauman/maintenance/adminlte/img/user.jpg') }}" alt="user image" class="online"/>
    <p class="message">
        <a href="#" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ $update->created_at }}</small>
            {{ $update->user->first_name }} {{ $update->user->last_name }}
        </a>
        
        {{ $update->content }}
        
        <div class="tools pull-right">
           	<a 
            	data-method="delete" 
                data-title="Delete message?"
                data-message="Are you sure you want to delete this message?" 
            	href="{{ route('maintenance.work-orders.updates.destroy', array($workOrder->id, $update->id)) }}">
                	<i class="fa fa-trash-o"></i>
          </a>
        </div>
    </p>
    
</div><!-- /.item -->
@endif