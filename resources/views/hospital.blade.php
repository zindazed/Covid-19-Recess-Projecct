<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>hospital entry</title>
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
        <div class="form-container" style="margin-top: -50px">
            <div class="image-holder"></div>
            <form action="addhospital" method="post">
                @csrf
                <h2 class="text-center"><strong>Hospital registration</strong></h2>
                <div class="form-group"><input class="form-control" type="text" name="head_name" placeholder="head name"></div>
                <div class="form-group"><input class="form-control" type="text" name="Email" placeholder="Head Email"></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Head password"></div>
                <div class="form-group"><input class="form-control" type="text" name="hospital_name" placeholder="Hospital name"></div>
                <div class="form-group"><input class="form-control" type="text" name="district" placeholder="District"></div>
                <div class="form-group d-flex">
                    <select name="category" style="padding: 2px;margin-right: 20px;width: 48%;background: rgb(247,249,252);color: rgb(80,94,108); border-style: hidden">
                        <option value="Public">Public</option>
                        <option value="Private">Private</option>
                    </select>
                    <select name="class" style="padding: 2px;margin: 0px;width: 48%;background: rgb(247,249,252);color: rgb(80,94,108); border-style: hidden">
                        <option value="General">General</option>
                        <option value="Regional Referral">Regional Referral</option>
                        <option value="National Referral">National Referral</option>
                    </select>
                </div>
                <div class="form-group d-flex">
                    <button class="btn btn-primary btn-block" type="submit" style="background: var(--blue); margin-right: 20px;">Add hospital</button>
                    <button class="btn btn-primary btn-block" type="reset" onclick="window.location.href='{{ url('/home') }}'" style="background: var(--blue);">Back</button>
                </div>
                @if($message)
                    <script>
                        window.alert("The hospital has been added successful");
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
