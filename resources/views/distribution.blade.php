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

<body id="page-top" style="min-width: 600px">
@include('layouts.app')
<div id="wrapper" style="margin-top: -50px;">
    @include('layouts.nav')
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <h1 style="margin-top: 4px;">Donations</h1>
                </div>
            </nav>
            <div class="container-fluid" style="margin-top: 12px;">
                @if(Auth::user()->position == 'Administrator')
                <div class="row">
                    <div class="col">
                        <div style="margin-bottom: 10px;"><a class="btn btn-primary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">Enter Donation</a>
                            <div class="collapse" id="collapse-1">
                                <form style="padding-left: 7px;padding-bottom: 5px;background: var(--white);" action="/donations" method="post">
                                    @csrf
                                    <label style="color: var(--blue);">Amount in Million UGX:</label>
                                    <input class="form-control" type="number" style="width: 200px;" name="ammount" required="true">
                                    <label style="color: var(--blue);">Donor Name:</label>
                                    <input class="form-control" type="text" style="width: 200px;" name="donor" required="true">
                                    <button class="btn btn-primary" type="submit" style="margin-top: 8px;font-size: 14px;background: var(--blue);padding-top: 0px;padding-bottom: 1px;">add</button>
                                    @if($new_donation)
                                        <script>
                                            if ({!! json_encode($new_donor) !!})
                                                var msg = "The new donor and the n";
                                            else
                                                var msg = "N";
                                            window.alert(msg+"ew donations have been successfully added");
                                        </script>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card shadow" style="min-width: 500px;">
                    <div class="card-header py-3">
                        <div class="col" id="salary">
                            <div style="margin-bottom: 10px;"><p class="text-primary m-0 font-weight-bold">Monthly Payments</p></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable" style="min-width: 500px;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Officer</th>
                                    <th>Amount</th>
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
                                    <td><strong>Amount</strong></td>
                                    <td><strong>Position</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            @if($officers and $salary)
                                <div class="d-flex justify-content-center pagination mx-auto">
                                    {!! $officers->onEachSide(1)->links() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card shadow" style="margin-top: 14px; min-width: 500px;">
                    <div class="card-header py-3" id="system">
                        <p class="text-primary m-0 font-weight-bold">Staff Paid by System</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable" style="min-width: 500px;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Officer</th>
                                    <th>Amount</th>
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
                                    <td><strong>Amount</strong></td>
                                    <td><strong>Position</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                                @if($consultants)
                                    <div class="d-flex justify-content-center pagination mx-auto">
                                        {!! $consultants->onEachSide(1)->links() !!}
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row" style="width: 100%; margin-top: 50px;">
                    <div class="col zed" style="width: 45%; min-width: 400px;">
                        <div class="card shadow mb-4 zed">
                            <div class="zed card-header d-flex justify-content-between align-items-center" style="min-width: 400px;">
                                <h6 class="text-primary font-weight-bold m-0">Donations Made by Well Wishers</h6>
                                <div class="zed dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="zed dropdown-menu shadow dropdown-menu-right animated--fade-in" style="width: 200px;">
                                        <p class="text-center dropdown-header">Well Wishers</p>
                                        <a class="dropdown-item" href="-1#graph">All Donors</a>
                                        @foreach($donors as $d)
                                         <a class="dropdown-item" href="{{$d->donor_ID}}#graph">{{$d->donor_name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-body zed" id="graph" style="min-width: 400px;">

                                @if($selected_donor)
                                    @foreach($selected_donor as $s)
                                        <p class="text-center ">{{$s->donor_name}}</p>
                                    @endforeach
                                @else
                                    <p class="text-center ">All Donors</p>
                                @endif
                                <div class="chart-area zed" style="width: auto; height: fit-content; margin: auto">
                                    <canvas id="chbar">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="zed col" style="width: 45%; min-width: 400px; margin: auto">
                        <div class="zed card shadow mb-4">
                            <div class="zed card-header d-flex justify-content-between align-items-center" style="min-width: 400px;">
                                <h6 class="text-primary font-weight-bold m-0">Donations Made by Well Wishers</h6>
                                <div class="zed dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="zed dropdown-menu shadow dropdown-menu-right animated--fade-in" style="width: 200px;">
                                        <p class="text-center dropdown-header">months</p>
                                        @foreach($months as $month)
                                            <a class="dropdown-item" href="{{$month->month_name}}#graph2">{{$month->month_name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-body zed" id="graph2" style="min-width: 400px;">

                                @if($selected_month)
                                    @foreach($selected_month as $sm)
                                    <p class="text-center ">{{$sm->month_name}}</p>
                                    @endforeach
                                @else
                                    <p class="text-center ">{{ \Carbon\Carbon::now()->monthName}}</p>
                                @endif
                                <div class="chart-area zed" style="width: auto; height: fit-content; margin: auto">
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
                                fontColor: "rgb(78,115,223)",
                                beginAtZero: true,
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Million UGX",
                            },
                        }],
                        xAxes: [{
                            ticks: {
                                fontColor: "rgb(78,115,223)",
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Months of the Year",
                            },
                        }],
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
                                fontColor: "rgb(78,115,223)",
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Million UGX",
                            },
                        }],
                        xAxes: [{
                            ticks: {
                                fontColor: "rgb(78,115,223)",
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Donors",
                            },
                        }],
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
