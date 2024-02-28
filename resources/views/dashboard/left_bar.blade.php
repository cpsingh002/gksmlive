<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <li>
                        @if (Auth::user()->user_type == 1) 
                            <a href="{{URL::to('/admin')}}">
                        @elseif (Auth::user()->user_type == 2) 
                            <a href="{{URL::to('/production')}}">
                         @elseif (Auth::user()->user_type == 3) 
                            <a href="{{URL::to('/opertor')}}">
                         @elseif (Auth::user()->user_type == 4) 
                            <a href="{{URL::to('/associate')}}">
                        @endif
                        <i class="fa-solid fa-house"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->user_type == 1)
                    <li>
                        <a href="{{URL::to('/productions')}}">
                            <!--<i data-feather="grid"></i>-->
                            <i class="fa-solid fa-building"></i>
                            <span data-key="t-apps">Production</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 1)
                    <li>
                        <a href="{{URL::to('/attributes')}}">
                            <!--<i data-feather="grid"></i>-->
                            <i class="fa-solid fa-braille"></i>
                            <span data-key="t-apps">Attributes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{URL::to('admin/opertor')}}">
                            <!--<i data-feather="grid"></i>-->
                            <i class="fa-solid fa-braille"></i>
                            <span data-key="t-apps">Operators</span>
                        </a>
                    </li>
                     <li>
                        <a href="{{URL::to('/teams')}}">
                            <!--<i data-feather="grid"></i>-->
                            <i class="fa-solid fa-users"></i>
                            <span data-key="t-apps">Teams</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 2)
                    <li class="menu-title" data-key="t-menu">User</li>
                    <li>
                        <a href="{{URL::to('/operators')}}">
                            <i class="fa-solid fa-user"></i>
                            <span data-key="t-apps">Operators</span>
                        </a>
                    </li>
                @endif
                    <li>
                        @if (Auth::user()->user_type == 1) 
                            <a href="{{URL::to('admin/schemes')}}">
                        @elseif (Auth::user()->user_type == 2) 
                            <a href="{{URL::to('production/schemes')}}">
                         @elseif (Auth::user()->user_type == 3) 
                            <a href="{{URL::to('opertor/schemes')}}">
                         @elseif (Auth::user()->user_type == 4) 
                            <a href="{{URL::to('associate/schemes')}}">
                        @endif
                                <i class="fa-solid fa-s"></i>
                                <span data-key="t-apps">Schemes</span>
                            </a>
                    </li>
                @if(Auth::user()->user_type == 1)
                    <li>
                        <a href="{{URL::to('/associates')}}">
                            <i class="fa-solid fa-users"></i>
                            <span data-key="t-apps">Associate</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 1)
                    <li>
                        <a href="{{URL::to('/associate-pending-request')}}">
                            <i class="fa-solid fa-user-group"></i>
                            <span data-key="t-apps">Associate Request</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type != 4)
                    <li>
                        <a href="{{URL::to('/property-reports')}}">
                            <i class="fa-solid fa-file-arrow-up"></i>
                            <span data-key="t-apps">Scheme Booking Reports</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4)
                    <li class="menu-title" data-key="t-menu">Associate Reports</li>
                    <li>
                        <a href="{{URL::to('/associate-property-reports')}}">
                            <i class="fa-solid fa-file-arrow-up"></i>
                            <span data-key="t-apps">Complete Booking Reports</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                    <li class="menu-title" data-key="t-menu">CSV</li>
                    <li>
                        @if (Auth::user()->user_type == 1) 
                            <a href="{{URL::to('admin/import-csv')}}">
                        @elseif (Auth::user()->user_type == 2) 
                            <a href="{{URL::to('production/import-csv')}}">
                       
                        @endif
                        <!--<i data-feather="grid"></i>-->
                            <i class="fa-solid fa-file-csv"></i>
                            <span data-key="t-apps">Import CSV</span>
                            </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>