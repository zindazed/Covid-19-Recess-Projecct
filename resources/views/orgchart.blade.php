<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Blank Page - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="dashboard.html"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="distribution.html"><i class="fa fa-dollar"></i><span>Money distribution</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}"><i class="fas fa-table"></i><span>patients&nbsp;</span></a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/orgchart') }}"><i class="fa fa-area-chart"></i><span>Organisation chart</span></a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="padding-left: 18px;"><i class="fa fa-pencil"></i>register</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="register.html"><i class="fa fa-male" style="width: 9px;height: 16px;font-size: 19px;"></i>&nbsp;Health officer</a><a class="dropdown-item" href="hospital.html"><i class="fa fa-institution" style="width: 11px;height: 16px;"></i>&nbsp;Hospital</a></div>
                    </li>
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
                        <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 12px;margin-top: 6px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;National referral hospitals</a>
                            <div class="collapse show" id="collapse-1">
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse-2" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Director 1</a>
                                    <div class="collapse" id="collapse-2">
                                        <div style="margin-left: 41px;color: var(--blue);">
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Hospital Staff</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);">Kakembo wilberforce</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Angela Katatumba</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Magom Hashim</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-8" href="#collapse-8" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Director 2</a>
                                    <div class="collapse" id="collapse-8">
                                        <div style="margin-left: 41px;color: var(--blue);">
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Hospital Staff</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);">Kakembo wilberforce</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Angela Katatumba</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Magom Hashim</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-3" href="#collapse-3" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Director 3</a>
                                    <div class="collapse" id="collapse-3">
                                        <div style="margin-left: 41px;color: var(--blue);">
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Hospital Staff</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);">Kakembo wilberforce</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Angela Katatumba</p>
                                            <p style="margin-left: 0px;margin-bottom: 2px;">Magom Hashim</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 12px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-4" href="#collapse-4" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;Regional referral hospital</a>
                            <div class="collapse show" id="collapse-4">
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-5" href="#collapse-5" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Superintendent 1</a>
                                    <div class="collapse" id="collapse-5" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">senior Officers</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-10" href="#collapse-10" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Superintendent 2</a>
                                    <div class="collapse" id="collapse-10" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">senior Officers</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-9" href="#collapse-9" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Superintendent 3</a>
                                    <div class="collapse" id="collapse-9" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">senior Officers</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-left: 5px;margin-right: 5px;margin-bottom: 2px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-6" href="#collapse-6" role="button" style="width: 100%;"><i class="fa fa-chevron-right"></i>&nbsp;General Referral hospital</a>
                            <div class="collapse show" id="collapse-6">
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-7" href="#collapse-7" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Head 1</a>
                                    <div class="collapse" id="collapse-7" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Health Officer</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-12" href="#collapse-12" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Head 2</a>
                                    <div class="collapse" id="collapse-12" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Health Officer</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                                <div style="margin-left: 27px;"><a class="btn btn-primary text-left" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-11" href="#collapse-11" role="button" style="width: 100%;margin-top: 3px;background: var(--cyan);"><i class="fa fa-chevron-right"></i>&nbsp;Head 3</a>
                                    <div class="collapse" id="collapse-11" style="margin-left: 42px;color: var(--blue);">
                                        <p style="margin-left: 0px;margin-bottom: 2px;background: var(--light);font-weight: bold;">Health Officer</p>
                                        <p style="margin-bottom: 2px;">Kakembo WIlberforce</p>
                                        <p style="margin-bottom: 2px;">Agnes Nandutu</p>
                                        <p style="margin-bottom: 2px;">Stella Nyanzi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
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
