<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>Profile <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">

        <!-- Menu Body -->
        <li class="user-body">
            <h3 class="text-center">Profile</h3>

            <hr>

            <ul class="text-center list-unstyled">
                <li><b>Name:</b> {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}</li>
                <li><b>Last Logged In:</b> {{ Sentry::getUser()->last_login }}</li>
            </ul>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            @if(Sentry::hasAccess('maintenance.admin.dashboard.index'))
                <div class="pull-left">
                    <a href="{{ route('maintenance.admin.dashboard.index') }}" class="btn btn-default btn-flat">Admin Dashboard</a>
                </div>
            @endif
            <div class="pull-right">
                <a href="{{ route('maintenance.logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>

    </ul>
</li>
