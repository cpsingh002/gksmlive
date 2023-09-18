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
@media(min-width:320px) and (max-width:767px){
    .auth-bg{
        display:none !important;
    }
}

@media(min-width:768px) and (max-width:1024px){
    .img-responsive{
    
    top: 15% !important;
}
}

.img-responsive{
    width: 40%;
    height: auto;
    position: fixed;
    top: 5%;
}
.bg-overlay{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
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
                                <div class="mb-4 mb-md-5">
                                    <a href="#" class="d-block auth-logo">
                                        <img src="assets/images/logo.png" alt="" height="80"> <span class="logo-txt">Dashboard</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Welcome Back !</h5>
                                        <p class="text-muted mt-2">Sign up to continue to Dashboard.</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                                        <label class="form-check-label" for="flexSwitchCheckDefault">For Hindi</label>
                                    </div>
                                    <form class="mt-4 pt-2" method="post" action="{{ route('register.admin') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Associate Name</label>
                                           <input type="text" class="form-control @error('associate_name') is-invalid @enderror" id="txtMessaged" id="associate_name" name="associate_name" value="" placeholder="सहयोगी का नाम दर्ज करें">
                                            <input type="text" class="form-control @error('associate_name') is-invalid @enderror" id="associate_named" name="associate_name" value="" placeholder="Enter Associate Name">
                                            <div id="newinput"></div>
                                            @error('associate_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Associate Contact Number</label>
                                            <input type="number" class="form-control @error('associate_number') is-invalid @enderror" id="username" name="associate_number" value="" placeholder="Enter Associate Number">
                                            @error('associate_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Associate Rera Number</label>
                                            <input type="text" class="form-control @error('associate_rera_number') is-invalid @enderror" id="username" name="associate_rera_number" value="" placeholder="Enter Associate Rera Name">
                                            @error('associate_rera_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Associate Email</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" name="email" value="" placeholder="Enter email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Password</label>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <!-- <div class="">
                                                        <a href="{{URL::to('/forgot-password')}}" class="text-muted">Forgot password?</a>
                                                    </div> -->
                                                </div>
                                            </div>

                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="" placeholder="Enter password" aria-label="Password" minlength="6" aria-describedby="password-addon">

                                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Immediate Uplinner Name</label>
                                            <input type="text" class="form-control @error('applier_name') is-invalid @enderror"  id="txtMessage" id="applier_name" name="applier_name" value="" placeholder="सहयोगी अपलाइनर का नाम दर्ज करें">
                                            <input type="text" class="form-control @error('applier_name') is-invalid @enderror" id="applier_named" name="applier_name" value="" placeholder="Enter Applier Name">
                                            <div id="newinput1"></div>
                                            @error('applier_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Immediate Uplinner Rera Number</label>
                                            <input type="text" class="form-control @error('applier_rera_number') is-invalid @enderror" id="username" name="applier_rera_number" value="" placeholder="Enter Associate Applier Rera Number">
                                            @error('applier_rera_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Team</label>
                                                <select id="servicearea" name="team"  class="form-control @error('team') is-invalid @enderror">
                                                    <option value=""> Select Team</option>
                                                    @foreach($teams as $list)            
                                                    <option value="{{ $list->public_id }}"> {{ $list->team_name }}</option>
                                                    @endforeach
                                                </select> 
                                            @error('team')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Sign Up</button>
                                        </div>
                                    </form>

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="{{url('')}}/assets/js/gtransapi.js"></script>

    <script>



$(function () {
        $('input[id="txtMessage"]').hide();
        $('input[id="txtMessaged"]').hide();

        //show it when the checkbox is clicked
        $('#flexSwitchCheckDefault').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[id="txtMessage"]').fadeIn();
                $('input[id="txtMessaged"]').fadeIn();
                $('input[id="applier_named"]').remove();
                $('input[id="associate_named"]').remove();
                
            } else {
                $('input[id="txtMessage"]').hide();
                $('input[id="txtMessaged"]').hide();
                newRowAdd1 ='<input type="text" class="form-control @error('applier_name') is-invalid @enderror" id="applier_named" name="applier_name" value="" placeholder="Enter Applier Name">'; 
                newRowAdd ='<input type="text" class="form-control @error('associate_name') is-invalid @enderror" id="associate_named" name="associate_name" value="" placeholder="Enter Associate Name">'; 
            $('#newinput').append(newRowAdd);
            $('#newinput1').append(newRowAdd1);
            }
        });
    });
</script>
<script type="text/javascript">
        google.load("elements", "1", { packages: "transliteration" });
        var control;
        function onLoad() {         
            var options = {
                //Source Language
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                // Destination language to Transliterate
                destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };                     
            control = new google.elements.transliteration.TransliterationControl(options);  
            control.makeTransliteratable(['txtMessage','txtMessaged']);   
        }
        google.setOnLoadCallback(onLoad);         
</script>

</body>

</html>