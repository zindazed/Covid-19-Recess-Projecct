<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Patients</title>
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
        @include('layouts.nav')
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h1>Patients</h1>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="card shadow" style="margin-top: 17px;">
                        <div class="row" style="margin-bottom: 9px;">
                            <div class="col text-left d-flex justify-content-center">
                                <div class="text-center">
                                    <h6 class="text-primary font-weight-bold m-0">Enrolled Patients</h6><button class="btn btn-primary" type="button" style="background: var(--cyan);width: 100%;padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-left: 4px;margin-top: 8px;">{{$patients_all->count()}}</button>
                                </div>
                                <div class="text-center" style="margin-left: 38px;">
                                    <h6 class="text-primary font-weight-bold m-0">Positive Cases</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$positive_cases->count()}}</button>
                                </div>
                                <div class="text-center" style="margin-left: 38px;">
                                    <h6 class="text-primary font-weight-bold m-0">False Positive Cases</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$False_positive_cases->count()}}</button>
                                </div>
                                <div class="text-center" style="margin-left: 38px;">
                                    <h6 class="text-primary font-weight-bold m-0">Symptomatics</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$Symptomatics->count()}}</button>
                                </div>
                                <div class="text-center" style="margin-left: 38px;">
                                    <h6 class="text-primary font-weight-bold m-0">Asymptomatic</h6><button class="btn btn-primary" type="button" style="width: 100%;background: var(--cyan);padding-top: 0px;padding-bottom: 0px;font-size: 25px;margin-top: 8px;">{{$Asymptomatic->count()}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Gender</th>
                                            <th>Case Type</th>
                                            <th>category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patients as $patient)
                                        <tr>
                                            <td>{{$patient->patient_name}}</td>
                                            <td>{{$patient->date_of_identification}}</td>
                                            <td>{{$patient->gender}}</td>
                                            <td>{{$patient->case_type}}</td>
                                            <td>{{$patient->category}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Date</strong></td>
                                            <td><strong>Gender</strong></td>
                                            <td><strong>Case Type</strong></td>
                                            <td><strong>Category</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing {{$patients->count()}} of
                                        {{$all_patients->count()}} Patients</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {!! $patients->links() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-7 col-xl-8 align-self-baseline">
                                <div class="card shadow mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary font-weight-bold m-0"><br>Variation in Percentage Change in Enrollment Figures<br><br></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="chbar">
                                            </canvas>
                                        </div>
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
</body>

</html>
