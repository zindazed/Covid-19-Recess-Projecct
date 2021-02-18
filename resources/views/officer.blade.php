<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Add Officer</title>
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
    <div class="register-photo" style="background: var(--blue);height: 100vh; margin-top: -50px">
        <div class="form-container">
            <div class="image-holder"></div>
            <form action="/addofficer" method="post">
                @csrf
                <h2 class="text-center"><strong>officer registration</strong></h2>
                <div class="form-group"><input class="form-control" type="text" name="officer_name" placeholder="officer name" required></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: var(--blue);">add officer</button></div>
                <div class="form-group"><button class="btn btn-primary btn-block" onclick="window.location.href='{{ url('/home') }}'" type="reset" style="background: var(--blue);">Back</button></div>
                @if($message == 1)
                    <script>
                        window.alert("The officer has been added successful");
                    </script>
                @elseif($message == 2)
                    <script>
                        window.alert("All available General hospitals are filled");
                    </script>
                @endif
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
