<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{URL::to('/')}}">

                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <!-- @if(Auth::user()->user_type == 1) -->
                <li>
                    <a href="{{URL::to('/productions')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Production</span>
                    </a>
                </li>
                <!-- @endif -->


                <!-- @if(Auth::user()->user_type == 1) -->
                <li>
                    <a href="{{URL::to('/attributes')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Attributes</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('/teams')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Teams</span>
                    </a>
                </li>
                <!-- @endif -->
                @if(Auth::user()->user_type == 2)
                <li class="menu-title" data-key="t-menu">User</li>
                <li>
                    <a href="{{URL::to('/operators')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Operators</span>
                    </a>

                </li>
                @endif

                <li>
                    <a href="{{URL::to('/schemes')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Schemes</span>
                    </a>

                </li>

                <!-- <li>
                    <a href="{{URL::to('/properties')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Property</span>
                    </a>

                </li> -->

                <!-- @if(Auth::user()->user_type == 1) -->
                <li>
                    <a href="{{URL::to('/associates')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Associate</span>
                    </a>

                </li>
                <!-- @endif -->


                <!-- @if(Auth::user()->user_type == 1) -->
                <li>
                    <a href="{{URL::to('/associate-pending-request')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Associate Request</span>
                    </a>

                </li>
                <!-- @endif -->

                <!-- @if(Auth::user()->user_type == 1) -->
                <li>
                    <a href="{{URL::to('/property-reports')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Book/Hold Reports</span>
                    </a>

                </li>
                <!-- @endif -->

                <li class="menu-title" data-key="t-menu">Associate Reports</li>
                <li>
                    <a href="{{URL::to('/associate-property-reports')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Book/Hold Reports</span>
                    </a>

                </li>
                <!-- @if(Auth::user()->user_type == 1) -->
                <li class="menu-title" data-key="t-menu">CSV</li>
                <li>
                    <a href="{{URL::to('/import-csv')}}">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Import CSV</span>
                    </a>

                </li>
                <!-- @endif -->


                <!-- <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="users"></i>
                    <span data-key="t-authentication">Authentication</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="auth-login.html" data-key="t-login">Login</a></li>
                    <li><a href="auth-register.html" data-key="t-register">Register</a></li>
                    <li><a href="auth-recoverpw.html" data-key="t-recover-password">Recover Password</a></li>
                    <li><a href="auth-lock-screen.html" data-key="t-lock-screen">Lock Screen</a></li>
                    <li><a href="auth-logout.html" data-key="t-logout">Log Out</a></li>
                    <li><a href="auth-confirm-mail.html" data-key="t-confirm-mail">Confirm Mail</a></li>
                    <li><a href="auth-email-verification.html" data-key="t-email-verification">Email Verification</a></li>
                    <li><a href="auth-two-step-verification.html" data-key="t-two-step-verification">Two Step Verification</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="file-text"></i>
                    <span data-key="t-pages">Pages</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="pages-starter.html" data-key="t-starter-page">Starter Page</a></li>
                    <li><a href="pages-maintenance.html" data-key="t-maintenance">Maintenance</a></li>
                    <li><a href="pages-comingsoon.html" data-key="t-coming-soon">Coming Soon</a></li>
                    <li><a href="pages-timeline.html" data-key="t-timeline">Timeline</a></li>
                    <li><a href="pages-faqs.html" data-key="t-faqs">FAQs</a></li>
                    <li><a href="pages-pricing.html" data-key="t-pricing">Pricing</a></li>
                    <li><a href="pages-404.html" data-key="t-error-404">Error 404</a></li>
                    <li><a href="pages-500.html" data-key="t-error-500">Error 500</a></li>
                </ul>
            </li>

            <li>
                <a href="layouts-horizontal.html">
                    <i data-feather="layout"></i>
                    <span data-key="t-horizontal">Horizontal</span>
                </a>
            </li> -->

                <!-- <li class="menu-title mt-2" data-key="t-components">Elements</li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="briefcase"></i>
                    <span data-key="t-components">Components</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="ui-alerts.html" data-key="t-alerts">Alerts</a></li>
                    <li><a href="ui-buttons.html" data-key="t-buttons">Buttons</a></li>
                    <li><a href="ui-cards.html" data-key="t-cards">Cards</a></li>
                    <li><a href="ui-carousel.html" data-key="t-carousel">Carousel</a></li>
                    <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Dropdowns</a></li>
                    <li><a href="ui-grid.html" data-key="t-grid">Grid</a></li>
                    <li><a href="ui-images.html" data-key="t-images">Images</a></li>
                    <li><a href="ui-modals.html" data-key="t-modals">Modals</a></li>
                    <li><a href="ui-offcanvas.html" data-key="t-offcanvas">Offcanvas</a></li>
                    <li><a href="ui-progressbars.html" data-key="t-progress-bars">Progress Bars</a></li>
                    <li><a href="ui-placeholders.html" data-key="t-progress-bars">Placeholders</a></li>
                    <li><a href="ui-tabs-accordions.html" data-key="t-tabs-accordions">Tabs & Accordions</a></li>
                    <li><a href="ui-typography.html" data-key="t-typography">Typography</a></li>
                    <li><a href="ui-toasts.html" data-key="t-typography">Toasts</a></li>
                    <li><a href="ui-video.html" data-key="t-video">Video</a></li>
                    <li><a href="ui-general.html" data-key="t-general">General</a></li>
                    <li><a href="ui-colors.html" data-key="t-colors">Colors</a></li>
                    <li><a href="ui-utilities.html" data-key="t-colors">Utilities</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="gift"></i>
                    <span data-key="t-ui-elements">Extended</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="extended-lightbox.html" data-key="t-lightbox">Lightbox</a></li>
                    <li><a href="extended-rangeslider.html" data-key="t-range-slider">Range Slider</a></li>
                    <li><a href="extended-sweet-alert.html" data-key="t-sweet-alert">SweetAlert 2</a></li>
                    <li><a href="extended-session-timeout.html" data-key="t-session-timeout">Session Timeout</a></li>
                    <li><a href="extended-rating.html" data-key="t-rating">Rating</a></li>
                    <li><a href="extended-notifications.html" data-key="t-notifications">Notifications</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i data-feather="box"></i>
                    <span class="badge rounded-pill bg-soft-danger text-danger float-end">7</span>
                    <span data-key="t-forms">Forms</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="form-elements.html" data-key="t-form-elements">Basic Elements</a></li>
                    <li><a href="form-validation.html" data-key="t-form-validation">Validation</a></li>
                    <li><a href="form-advanced.html" data-key="t-form-advanced">Advanced Plugins</a></li>
                    <li><a href="form-editors.html" data-key="t-form-editors">Editors</a></li>
                    <li><a href="form-uploads.html" data-key="t-form-upload">File Upload</a></li>
                    <li><a href="form-wizard.html" data-key="t-form-wizard">Wizard</a></li>
                    <li><a href="form-mask.html" data-key="t-form-mask">Mask</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="sliders"></i>
                    <span data-key="t-tables">Tables</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="tables-basic.html" data-key="t-basic-tables">Bootstrap Basic</a></li>
                    <li><a href="tables-datatable.html" data-key="t-data-tables">DataTables</a></li>
                    <li><a href="tables-responsive.html" data-key="t-responsive-table">Responsive</a></li>
                    <li><a href="tables-editable.html" data-key="t-editable-table">Editable</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="pie-chart"></i>
                    <span data-key="t-charts">Charts</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="charts-apex.html" data-key="t-apex-charts">Apexcharts</a></li>
                    <li><a href="charts-echart.html" data-key="t-e-charts">Echarts</a></li>
                    <li><a href="charts-chartjs.html" data-key="t-chartjs-charts">Chartjs</a></li>
                    <li><a href="charts-knob.html" data-key="t-knob-charts">Jquery Knob</a></li>
                    <li><a href="charts-sparkline.html" data-key="t-sparkline-charts">Sparkline</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="cpu"></i>
                    <span data-key="t-icons">Icons</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="icons-boxicons.html" data-key="t-boxicons">Boxicons</a></li>
                    <li><a href="icons-materialdesign.html" data-key="t-material-design">Material Design</a></li>
                    <li><a href="icons-dripicons.html" data-key="t-dripicons">Dripicons</a></li>
                    <li><a href="icons-fontawesome.html" data-key="t-font-awesome">Font Awesome 5</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="map"></i>
                    <span data-key="t-maps">Maps</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="maps-google.html" data-key="t-g-maps">Google</a></li>
                    <li><a href="maps-vector.html" data-key="t-v-maps">Vector</a></li>
                    <li><a href="maps-leaflet.html" data-key="t-l-maps">Leaflet</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="share-2"></i>
                    <span data-key="t-multi-level">Multi Level</span>
                </a>
                <ul class="sub-menu" aria-expanded="true">
                    <li><a href="javascript: void(0);" data-key="t-level-1-1">Level 1.1</a></li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow" data-key="t-level-1-2">Level 1.2</a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="javascript: void(0);" data-key="t-level-2-1">Level 2.1</a></li>
                            <li><a href="javascript: void(0);" data-key="t-level-2-2">Level 2.2</a></li>
                        </ul>
                    </li>
                </ul>
            </li> -->

            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div>l