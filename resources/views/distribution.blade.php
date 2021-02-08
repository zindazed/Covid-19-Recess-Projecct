<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Distribution</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
@include('layouts.app')
<div id="wrapper" style="margin-top: -50px;">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link" href="/home"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ url('/donations') }}"><i class="fa fa-dollar"></i><span>Money distribution</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/patients') }}"><i class="fas fa-table"></i><span>patients&nbsp;</span></a></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="/hierachy"><i class="fa fa-area-chart"></i><span>Organisation chart</span></a></li>
                @if(Auth::user()->is_admin == 1)
                <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="padding-left: 18px;"><i class="fa fa-pencil"></i>register</a>
                    <div class="dropdown-menu"><a class="dropdown-item" href="/officer"><i class="fa fa-male" style="width: 9px;height: 16px;font-size: 19px;"></i>&nbsp;Health officer</a><a class="dropdown-item" href="/hospital"><i class="fa fa-institution" style="width: 11px;height: 16px;"></i>&nbsp;Hospital</a></div>
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
                    <h1 style="margin-top: 4px;">Donations and distribution</h1>
                </div>
            </nav>
            <div class="container-fluid" style="margin-top: 12px;">
                @if(Auth::user()->is_admin == 1)
                <div class="row">
                    <div class="col">
                        <div style="margin-bottom: 10px;"><a class="btn btn-primary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">enter donation</a>
                            <div class="collapse" id="collapse-1">
                                <form style="padding-left: 7px;padding-bottom: 5px;background: var(--white);" action="/donations" method="post">
                                    @csrf
                                    <label style="color: var(--blue);">Ammount:</label>
                                    <input class="form-control" type="text" style="width: 200px;" name="ammount" required="true">
                                    <label style="color: var(--blue);">donor name:</label>
                                    <input class="form-control" type="text" style="width: 200px;" name="donor" required="true">
                                    <label style="color: var(--blue);">Date e.g 12/02/2015:</label>
                                    <input class="form-control" type="text" style="width: 200px;" name="date" required="true">
                                    <button class="btn btn-primary" type="submit" style="margin-top: 8px;font-size: 14px;background: var(--blue);padding-top: 0px;padding-bottom: 1px;">add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="col">
                            <div style="margin-bottom: 10px;"><a class="btn btn-primary" aria-expanded="true" aria-controls="collapse-1" href="salary" role="button">Generate Monthly Payments</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Officer</th>
                                    <th>Ammount</th>
                                    <th>Position</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($officers and $salary)
                                            @foreach($officers as $of)
                                            <tr>
                                                <td>{{$of->id}}</td>
                                                <td>{{$of->name}}</td>
                                                @switch($of->position)
                                                    @case("Health Officer")
                                                        <td>{{$salary->Officer}}</td>
                                                        @break
                                                    @case("Senior health Officer")
                                                    @case("Consultant")
                                                        <td>{{$salary->Senior_Officer}}</td>
                                                        @break
                                                    @case("Head")
                                                        <td>{{$salary->Head}}</td>
                                                        @break
                                                    @case("Superintendent")
                                                        <td>{{$salary->Superintendent}}</td>
                                                        @break
                                                    @case("Director")
                                                        <td>{{$salary->Director}}</td>
                                                        @break
                                                    @case("Administrator")
                                                        <td>{{$salary->Administrator}}</td>
                                                        @break
                                                @endswitch
                                                <td>{{$of->position}}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                    <td><strong>ID</strong></td>
                                    <td><strong>Officer</strong></td>
                                    <td><strong>Ammount</strong></td>
                                    <td><strong>Position</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            @if($officers and $salary)
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing {{$officers->count()}} of
                                        {{$all_officers->count()}} Officers</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {!! $officers->links() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card shadow" style="margin-top: 14px;">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Staff paid by system</p>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="text-md-right dataTables_filter" id="dataTable_filter-1"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search officer's name"></label></div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Officer</th>
                                    <th>Ammount</th>
                                    <th>Position</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($consultants)
                                    @foreach($consultants as $of)
                                        <tr>
                                            <td>{{$of->officer_ID}}</td>
                                            <td>{{$of->officer_name}}</td>
                                            <td>10</td>
                                            <td>{{$of->officer_position}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td><strong>ID</strong></td>
                                    <td><strong>Officer</strong></td>
                                    <td><strong>Ammount</strong></td>
                                    <td><strong>Position</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info-1" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary font-weight-bold m-0">donations made by well wishers</h6>
                                <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in" style="width: 200px;">
                                        <p class="text-center dropdown-header">Well wishers</p>
                                        @foreach($donors as $d)
                                         <a class="dropdown-item" href="{{$d->donor_ID}}">{{$d->donor_name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if($selected_donor)
                                    @foreach($selected_donor as $s)
                                        <p class="text-center ">{{$s->donor_name}}</p>
                                    @endforeach
                                @else
                                    <p class="text-center ">All Donors</p>
                                @endif
                                <div class="chart-area">
                                    <canvas id="chbar">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary font-weight-bold m-0">donations made by well wishers</h6>
                                <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in" style="width: 200px;">
                                        <p class="text-center dropdown-header">months</p>
                                        @foreach($months as $month)
                                            <a class="dropdown-item" href="{{$month->month_name}}">{{$month->month_name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if($selected_month)
                                    @foreach($selected_month as $sm)
                                    <p class="text-center ">{{$sm->month_name}}</p>
                                    @endforeach
                                @else
                                    <p class="text-center ">July</p>
                                @endif
                                <div class="chart-area">
                                    <canvas id="chbar2">
                                    </canvas>
                                </div>
                            </div>
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

    <script>
        var cdata = {!! json_encode($data) !!};
        var chartData = {
            labels: ["jan","feb", "mar","apr","may","june","july","aug","sept","oct","nov","dec"],

            datasets: [{
                data: cdata,
            }]
        };

        var chBar = document.getElementById("chbar");
        if (chBar){
            new Chart(chBar, {
                type: 'bar',
                data: chartData,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }
    </script>

    <script>
        var cdata = {!! json_encode($month_donations) !!};
        var clabels = {!! json_encode($month_donor) !!};
        var chartData = {
            labels: clabels,

            datasets: [{
                data: cdata,
            }]
        };

        var chBar = document.getElementById("chbar2");
        if (chBar){
            new Chart(chBar, {
                type: 'bar',
                data: chartData,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }
    </script>
</body>

</html>
