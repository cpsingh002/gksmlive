
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{url('')}}/assets/images/logo.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('')}}/assets/images/logo.png" alt="" height="24"> <span class="logo-txt">Dashboard</span>
                    </span>
                </a>

                <a href="{{URL::to('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{url('')}}/assets/images/logo.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('')}}/assets/images/logo.png" alt="" height="24"> <span class="logo-txt">Dashboard</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <!-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form> -->
        </div>

        <div class="d-flex">

            <!--<div class="dropdown d-inline-block d-lg-none ms-2">-->
            <!--    <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--        <i data-feather="search" class="icon-lg"></i>-->
            <!--    </button>-->
            <!--    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">-->

            <!--        <form class="p-3">-->
            <!--            <div class="form-group m-0">-->
            <!--                <div class="input-group">-->
            <!--                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">-->

            <!--                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </form>-->
            <!--    </div>-->
            <!--</div>-->



            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>



            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">{{$notices->count()}}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> Unread ({{$notices->count()}})</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @forelse($notices as $note)
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{url('')}}/assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{$note->action}}</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">{{$note->msg}}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>{{$note->created_at}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <h6 class="mb-1">No notification</h6>
                        @endforelse
                       
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{route('property.getnotications')}}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span>
                        </a>
                    </div>
                </div>
            </div>



            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->user_type == 2)
                     <img class="rounded-circle header-profile-user" src="{{URL::to('/files',Auth::user()->image)}}">
                    @else
                    <img class="rounded-circle header-profile-user" src="{{url('')}}/assets/images/logo.png" alt="Avatar">
                    @endif
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{Auth::user()->email}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @if(Auth::user()->user_type == 2)

                    <a class="dropdown-item" href="{{URL::to('/edit-profile')}}"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>

                    @endif
                    <!-- <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock Screen</a> -->
                    <a href="#"class="dropdown-item" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal" id="button1"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    @if(Auth::user()->user_type == 4)
                    <a class="dropdown-item" href="{{URL::to('/associate/delete-account')}}"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Delete Account</a>
                    @endif
                    <a class="dropdown-item" href="{{URL::to('/logout')}}"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>


    <div id="myModal" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form" method="post" action="{{url('change-password')}}">
                         @csrf
                <div class="modal-body">
                    
                    
                    
                    
                    
                                    
                                    
                        <div class="form-group" >
                            <label>Old Password</label>
                            <div class="input-group auth-pass-inputgroup">
                                <input type="password" name="old_password" class="form-control @error('password') is-invalid @enderror"  placeholder="Old Password" value="" aria-label="Password" aria-describedby="password-addon">
                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label>New Password</label>
                            <div class="input-group auth-pass-inputgroup">
                                <input type="password" name="new_password" class="form-control @error('password') is-invalid @enderror"  placeholder="New Password" value="" aria-label="Password" aria-describedby="password-addon">
                                <button class="btn btn-light shadow-none ms-0 password-addon" type="button" id=""><i class="mdi mdi-eye-outline"></i></button>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
                        

                                            