<style>
    .navbar-nav > .notifications-menu > .dropdown-menu, .navbar-nav > .messages-menu > .dropdown-menu, .navbar-nav > .tasks-menu > .dropdown-menu {
    width:400px;
}
</style>

<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        
        <i class="fa fa-warning"></i>
        @if($notifications->count() > 0)
            <span class="label label-warning">{{ $notifications->count() }}</span>
        @endif
    </a>
    <ul class="col-md-12 dropdown-menu">
        <li class="header">You have {{ $notifications->count() }} notification(s)</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <div class="infinite-scroll">
                <ul class="menu">
                    @foreach($notifications as $notification)
                        @if(!$notification->read)
                            <li>
                                <a class="notification" data-read-url="{{ route('maintenance.api.notifications.update', $notification->id) }}" href="{{ $notification->link }}">
                                    <i class="{{ $notification->icon }}"></i> {{ $notification->message }}
                                    
                                    
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="slimScrollBar"></div>
                <div class="slimScrollRail"></div>
            </div>
        </li>
        <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>