<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>Profile <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <img src="{{ asset('packages/stevebauman/maintenance/adminlte/img/user.jpg') }}" class="img-circle" alt="User Image" />
            <p>
                {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}
                <small>Member since {{ Sentry::getUser()->created_at->format('M. Y') }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body"></li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="{{ route('maintenance.logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>