<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>hierachy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">
@include('layouts.app')
<div id="wrapper" style="margin-top: -50px;">
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
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <h1>Hierachy</h1>
                </div>
            </nav>
            <div class="row">
                <div class="col">
                    <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 12px;margin-top: 6px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;National Referral Hospitals</a>
                        <div class="collapse" id="collapse-1">
                            @foreach($directors as $d)
                            <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse{{$d->head_ID}}" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;{{$d->head_name}}</a>
                                <div class="collapse" id="collapse{{$d->head_ID}}">
                                    <div style="margin-left: 41px;color: var(--blue);">
                                        @foreach($officers = DB::Table('officers')->select('head_ID', 'officer_name')->where('head_ID', '=', $d->head_ID)->where('officer_position', '=', 'Consultant')->get() as $of)
                                            <p style="margin-bottom: 2px;">{{$of->officer_name}}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 12px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-4" href="#collapse-4" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;Regional Referral Hospital</a>
                        <div class="collapse" id="collapse-4">
                            @foreach($supretendants as $sup)
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse{{$sup->head_ID}}" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;{{$sup->head_name}}</a>
                                    <div class="collapse" id="collapse{{$sup->head_ID}}">
                                        <div style="margin-left: 41px;color: var(--blue);">
                                            @foreach($officers = DB::Table('officers')->select('head_ID', 'officer_name')->where('head_ID', '=', $sup->head_ID)->where('officer_position', '=', 'Senior health Officer')->get() as $of)
                                                <p style="margin-bottom: 2px;">{{$of->officer_name}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 2px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-6" href="#collapse-6" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;General Hospital</a>
                        <div class="collapse" id="collapse-6">
                            @foreach($general_heads as $g_head)
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse{{$g_head->head_ID}}" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;{{$g_head->head_name}}</a>
                                    <div class="collapse" id="collapse{{$g_head->head_ID}}">
                                        <div style="margin-left: 41px;color: var(--blue);">
                                            @foreach($officers = DB::Table('officers')->select('head_ID', 'officer_name')->where('head_ID', '=', $g_head->head_ID)->where('officer_position', '=', 'Health Officer')->get() as $of)
                                                <p style="margin-bottom: 2px;">{{$of->officer_name}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © CodeValley 2021</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/theme.js"></script>
</body>

</html>
