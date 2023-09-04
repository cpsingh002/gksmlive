<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard " name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- preloader css -->
    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>
<style>
@media(min-width:350px) and (max-width:767px){
    .bg-overlay img{
        display:none;
    }
}
</style>
<body>

    <!-- <body data-layout="horizontal"> -->
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="{{URL::to('/login')}}" class="d-block auth-logo">
                                    <img src="assets/images/logo.png" alt="" height="80"> <span class="logo-txt">Dashboard</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center mt-5">
                                        <h5 class="mb-0">Welcome To Forgot Password Page !</h5>
                                    </div>
                                    @if(session('danger'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong> {{ session('danger') }}</strong>.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @elseif(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong> {{ session('success') }}</strong>.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <form class="mt-4 pt-2" method="post" action="{{ route('forgot-password.check-email') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Select Role</label>
                                            <select class="form-control" name="role">
                                                <option>Select Role</option>
                                                <!-- <option value="0">Super Admin</option> -->
                                                <option value="1">Production/Company</option>
                                                <option value="2">Operator</option>
                                                <option value="3">Associate </option>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" name="email" value="" placeholder="Enter email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Submit</button>
                                        </div>
                                    </form>
                                    <div class="flex-shrink-0">
                                        <div class="">
                                            <a href="{{URL::to('/login')}}" class="btn btn-primary w-100">Login ?</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> Dashboard . Crafted with by Softhunters</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-primary text-center">
                            <img src="assets/images/logo.png" class="img-responsive mt-5">
                        </div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">

                                        </div>
                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>


    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="assets/libs/pace-js/pace.min.js"></script>
    <!-- password addon init -->
    <script src="assets/js/pages/pass-addon.init.js"></script>

</body>

</html>