<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <hr class="sidebar-divider my-0">
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item"><a class="nav-link" href="/home"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/donations') }}"><i class="fa fa-dollar"></i><span>Money Distribution</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/patients') }}"><i class="fas fa-table"></i><span>Patients&nbsp;</span></a></li>
            <li class="nav-item"></li>
            <li class="nav-item"><a class="nav-link" href="/hierachy"><i class="fa fa-area-chart"></i><span>Hierachy</span></a></li>
            @if(Auth::user()->position == 'Administrator')
                <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="padding-left: 18px;"><i class="fa fa-pencil"></i>Register</a>
                    <div class="dropdown-menu"><a class="dropdown-item" href="/officer"><i class="fa fa-male" style="width: 9px;height: 16px;font-size: 19px;"></i>&nbsp;Health Officer</a><a class="dropdown-item" href="/hospital"><i class="fa fa-institution" style="width: 11px;height: 16px;"></i>&nbsp;Hospital</a></div>
                </li>
            @endif
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
</nav>
