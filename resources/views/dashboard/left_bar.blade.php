<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            @if(Auth::user()->user_type != 5 )
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" data-key="t-menu">Menu</li>
                    <li>
                        @if (in_array(Auth::user()->user_type,[1,6])) 
                            <a href="{{URL::to('/admin')}}" id="dsahboardlogo">
                        @elseif (Auth::user()->user_type == 2) 
                            <a href="{{URL::to('/production')}}" id="dsahboardlogo">
                        @elseif (Auth::user()->user_type == 3) 
                            <a href="{{URL::to('/opertor')}}" id="dsahboardlogo">
                        @elseif (Auth::user()->user_type == 4) 
                            <a href="{{URL::to('/associate')}}" id="dsahboardlogo">
                        @endif
                            <i class="fa-solid fa-house"></i>
                            <span data-key="t-dashboard">Dashboard</span>
                            </a>
                    </li>
                    <li>
                        <a href="{{route('getcustomerlist')}}"><i class="fa-solid fa-building"></i><span data-key="t-apps">Customer List</span></a>
                    </li>
                    @if(in_array(Auth::user()->user_type, [1,6]))
                        <li>
                            <a href="{{URL::to('/productions')}}">
                                <!--<i data-feather="grid"></i>-->
                                <i class="fa-solid fa-building"></i>
                                <span data-key="t-apps">Production</span>
                            </a>
                        </li>
                    @endif
                    @if(in_array(Auth::user()->user_type, [1,6]))
                        <li>
                            <a href="{{URL::to('/admin/attributes')}}">
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
                        @if(Auth::user()->user_type == 1)
                        <li>
                            <a href="{{URL::to('group_message')}}">
                                <!--<i data-feather="grid"></i>-->
                                <i class="fa-solid fa-braille"></i>
                                <span data-key="t-apps">Message</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{URL::to('/teams')}}">
                                <!--<i data-feather="grid"></i>-->
                                <i class="fa-solid fa-users"></i>
                                <span data-key="t-apps">Teams</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/visitor')}}">
                                
                                <i class="fa-solid fa-users"></i>
                                <span data-key="t-apps">Visitor</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="{{URL::to('/plot-history')}}">
                                <i class="fa-solid fa-s"></i>
                                <span data-key="t-apps">Plot History</span>
                            </a>
                        </li> -->
                        @if(Auth::user()->id == 2)
                            <li>
                                <a href="{{URL::to('/user-history')}}">
                                    <i class="fa-solid fa-s"></i>
                                    <span data-key="t-apps">User Action History</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{URL::to('/scheme-csv')}}">
                                    <i class="fa-solid fa-s"></i>
                                    <span data-key="t-apps">Scheme CSV</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    @if(Auth::user()->user_type == 2)
                        <li>
                            <a href="{{URL::to('/production/attributes')}}">
                                <i class="fa-solid fa-braille"></i>
                                <span data-key="t-apps">Attributes</span>
                            </a>
                        </li>
                        <li class="menu-title" data-key="t-menu">User</li>
                        <li>
                            <a href="{{URL::to('/operators')}}">
                                <i class="fa-solid fa-user"></i>
                                <span data-key="t-apps">Operators</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="{{URL::to('/plot-history')}}">
                                <i class="fa-solid fa-s"></i>
                                <span data-key="t-apps">Plot History</span>
                            </a>
                        </li> -->
                    @endif
                    <li>
                        @if (in_array(Auth::user()->user_type, [1,6])) 
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
                    @if(in_array(Auth::user()->user_type, [1,6]))
                        <li>
                            <a href="{{URL::to('/associates')}}">
                                <i class="fa-solid fa-users"></i>
                                <span data-key="t-apps">Associate</span>
                            </a>
                        </li>
               
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
                        <li>
                            <a href="{{URL::to('/plot-history')}}">
                                <i class="fa-solid fa-s"></i>
                                <span data-key="t-apps">Plot History</span>
                            </a>
                        </li>
                    @endif
                    @if(in_array(Auth::user()->user_type,[1,4,6,2]))
                        <li class="menu-title" data-key="t-menu">Associate Reports</li>
                        @if(in_array(AUth::user()->user_type, [1,2,6]))
                            <li>
                                <a href="{{URL::to('/reports-options')}}">
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                    <span data-key="t-apps">Reports Option</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->user_type != 2)
                            <li>
                                <a href="{{URL::to('/associate-property-reports')}}">
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                    <span data-key="t-apps">Complete Booking Reports</span>
                                </a>
                            </li>
                        @endif
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
                        <li>
                            @if (Auth::user()->user_type == 1) 
                                <a href="{{URL::to('admin/relunchdate')}}">
                            @elseif (Auth::user()->user_type == 2) 
                                <a href="{{URL::to('production/relunchdate')}}">
                            @endif
                                <i class="fa-solid fa-file-csv"></i>
                                <span data-key="t-apps">Re-launch Date  CSV</span>
                                </a>
                        </li>
                    @endif
                </ul>
            @else
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" data-key="t-menu">Menu</li>
                    <li>
                        <a href="{{URL::to('vistor/dashboard')}}">
                            <i class="fa-solid fa-house"></i>
                            <span data-key="t-dashboard">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{URL::to('production/schemes')}}">
                            <i class="fa-solid fa-s"></i>
                            <span data-key="t-apps">Schemes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{URL::to('/property-reports')}}">
                            <i class="fa-solid fa-file-arrow-up"></i>
                            <span data-key="t-apps">Scheme Booking Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{URL::to('/reports-options')}}">
                            <i class="fa-solid fa-file-arrow-up"></i>
                            <span data-key="t-apps">Reports Option</span>
                        </a>
                    </li>
                </ul>
            @endif
        </div>
        <!-- Sidebar -->
    </div>
</div>