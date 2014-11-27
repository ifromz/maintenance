@yield('dropdown.extra.top')

<div class="btn-group">
    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
        @section('dropdown.head.content')
            Action
            <span class="caret"></span>
        @show
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        @yield('dropdown.body.content')
    </ul>
</div>

@yield('dropdown.extra.bottom')