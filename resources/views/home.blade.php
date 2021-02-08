<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/donations') }}"><i class="fa fa-dollar"></i><span>Money Distribution</span></a></li>
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
                        <h1>Dashboard</h1>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row" style="margin-bottom: 9px;">
                        <div class="col text-left d-flex justify-content-center">
                            <div class="text-center">
                                <h6 class="text-primary font-weight-bold m-0">Enrolled Patients</h6><button class="btn btn-primary" type="button" style="background: var(--cyan);width: 100%;padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-left: 4px;margin-top: 8px;">{{$patients->count()}}</button>
                            </div>
                            <div class="text-center" style="margin-left: 38px;">
                                <h6 class="text-primary font-weight-bold m-0">Number of Officers</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$officers->count()}}</button>
                            </div>
                            <div class="text-center" style="margin-left: 38px;">
                                <h6 class="text-primary font-weight-bold m-0">Available Donation Funds</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$total}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary font-weight-bold m-0">Donations Made By Well Wishers</h6>
                                </div>
                                <div class="card-body" style="padding: 0px!important;">
                                    <div class="chart-area" style="margin-top: 10px;">
                                        <p class="text-center ">All Well Wishers</p>
                                        <canvas id="chbar1">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary font-weight-bold m-0">Donations Made in a Given Month</h6>

                                </div>
                                <div class="card-body " style="padding: 0px!important;">
                                    <div class="chart-area" style="margin-top: 10px;">
                                        <p class="text-center ">JULY</p>
                                        <canvas id="chbar2">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 50%;" >
                        <div class="col " style="width: 100%;">
                            <div class="card shadow mb-4"  >
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary font-weight-bold m-0">Variation in Percentage Change in Enrollment Figures</h6>
                                </div>
                                <div class="card-body" >
                                    <div class="chart-area" style="margin-top: 10px;">
                                        <canvas id="chbar3" >
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

        var chBar = document.getElementById("chbar1");
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

    <script>
        var cdata = {!! json_encode($data1) !!};
        var chartData = {
            labels: ["jan","feb", "mar","apr","may","june","july","aug","sept","oct","nov","dec"],

            datasets: [{
                data: cdata,
            }]
        };

        var chBar = document.getElementById("chbar3");
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
