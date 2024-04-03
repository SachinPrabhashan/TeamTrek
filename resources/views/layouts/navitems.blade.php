<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TeamTrek</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <link type="image/png" sizes="32x32" rel="icon" href="{{ asset('img/icons8-developer-32.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/smain.css') }}" rel="stylesheet">

    {{-- Datatable --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.semanticui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
    <script src="{{ asset('lib/chart/chart.min.js') }}"></script>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="{{ asset('js/smain.js') }}"></script>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.semanticui.min.css">

    <style>
        .checkbox-wrapper-46 input[type="checkbox"] {
          display: none;
          visibility: hidden;
        }

        .checkbox-wrapper-46 .cbx {
          margin: auto;
          -webkit-user-select: none;
          user-select: none;
          cursor: pointer;
        }
        .checkbox-wrapper-46 .cbx span {
          display: inline-block;
          vertical-align: middle;
          transform: translate3d(0, 0, 0);
        }
        .checkbox-wrapper-46 .cbx span:first-child {
          position: relative;
          width: 18px;
          height: 18px;
          border-radius: 3px;
          transform: scale(1);
          vertical-align: middle;
          border: 1px solid #9098A9;
          transition: all 0.2s ease;
        }
        .checkbox-wrapper-46 .cbx span:first-child svg {
          position: absolute;
          top: 3px;
          left: 2px;
          fill: none;
          stroke: #FFFFFF;
          stroke-width: 2;
          stroke-linecap: round;
          stroke-linejoin: round;
          stroke-dasharray: 16px;
          stroke-dashoffset: 16px;
          transition: all 0.3s ease;
          transition-delay: 0.1s;
          transform: translate3d(0, 0, 0);
        }
        .checkbox-wrapper-46 .cbx span:first-child:before {
          content: "";
          width: 100%;
          height: 100%;
          background: #506EEC;
          display: block;
          transform: scale(0);
          opacity: 1;
          border-radius: 50%;
        }
        .checkbox-wrapper-46 .cbx span:last-child {
          padding-left: 8px;
        }
        .checkbox-wrapper-46 .cbx:hover span:first-child {
          border-color: #506EEC;
        }

        .checkbox-wrapper-46 .inp-cbx:checked + .cbx span:first-child {
          background: #506EEC;
          border-color: #506EEC;
          animation: wave-46 0.4s ease;
        }
        .checkbox-wrapper-46 .inp-cbx:checked + .cbx span:first-child svg {
          stroke-dashoffset: 0;
        }
        .checkbox-wrapper-46 .inp-cbx:checked + .cbx span:first-child:before {
          transform: scale(3.5);
          opacity: 0;
          transition: all 0.6s ease;
        }

        @keyframes wave-46 {
          50% {
            transform: scale(0.9);
          }
        }
      </style>
</head>

<body>
    <div class="waveback">


        <div class="container-xxl position-relative  d-flex p-0 ">
            <!-- Spinner Start -->
            <div id="spinner"
                class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->


            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="{{ route('dashboard.show') }}" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">TeamTrek</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        <div class="position-relative">
                            @if (Auth::user()->role->id == 1)
                                <img class="rounded-circle" src="{{ asset('img/root.gif') }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @elseif(Auth::user()->role->id == 2)
                                <img class="rounded-circle" src="{{ asset('img/admin.gif') }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @elseif(Auth::user()->role->id == 3)
                                <img class="rounded-circle" src="{{ asset('img/employee.gif') }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @else
                                <img class="rounded-circle" src="{{ asset('img/user.gif') }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @endif
                            <div
                                class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <span>{{ Auth::user()->role->name }}</span>
                        </div>
                    </div>
                    <div class="navbar-nav w-100">

                        <a href="{{ route('dashboard.show') }}"
                            class="nav-item nav-link  {{ request()->is('dashboard') ? ' active' : '' }}"><i
                                class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

                        @RootOrAdmin
                            {{-- <a href="/admin/UserManagement" class="nav-item nav-link"><i class="fa-solid fa-users me-2"></i>User Management</a> --}}

                            <div class="nav-item dropdown">
                                <a href="#"
                                    class="nav-link dropdown-toggle {{ request()->is('user-managements/*') ? ' active' : '' }}"
                                    data-bs-toggle="dropdown"><i class="fa-solid fa-users me-2"></i>User Management</a>
                                <div
                                    class="dropdown-menu {{ request()->is('user-managements/*') ? ' show' : '' }} bg-transparent border-0">
                                    @Root
                                        <a href="{{ route('new.admins') }}"
                                            class="dropdown-item {{ request()->is('user-managements/admin') ? ' active' : '' }}">Create
                                            Admin</a>
                                    @endRoot
                                    <a href="{{ route('new.employee') }}"
                                        class="dropdown-item {{ request()->is('user-managements/employee') ? ' active' : '' }}">Create
                                        Employee</a>
                                    <a href="{{ route('new.clients') }}"
                                        class="dropdown-item {{ request()->is('user-managements/client') ? ' active' : '' }}">Create
                                        Client</a>
                                </div>
                            </div>
                        @endRootOrAdmin



                        <div class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle  {{ request()->is('support-contract/*') ? ' active' : '' }}"
                                data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Support Contract</a>
                            <div
                                class="dropdown-menu {{ request()->is('support-contract/*') ? ' show' : '' }} bg-transparent border-0">
                                @AdminOrEmployee
                                    @Admin
                                        <a href="{{ route('admin.ScHandling') }}"
                                            class="dropdown-item {{ request()->is('support-contract/admin-schandling') ? ' active' : '' }}">SC
                                            Handling</a>
                                        <a href="{{ route('admin.ScInstance') }}"
                                            class="dropdown-item {{ request()->is('support-contract/admin-scinstance') ? ' active' : '' }}">SC
                                            Instance Handling</a>
                                    @endAdmin
                                    <a href="{{ route('scTaskMonitor') }}"
                                        class="dropdown-item {{ request()->is('support-contract/sc-task-monitor', 'support-contract/sc-task-monitor/sub-task-handle', 'support-contract/sc-all-task-monitor') ? ' active' : '' }}">SC
                                        Task Monitor</a>
                                    @Admin
                                        <a href="{{ route('scReports') }}"
                                            class="dropdown-item {{ request()->is('support-contract/sc-reports') ? ' active' : '' }}">SC
                                            Reports</a>
                                    @endAdmin
                                @endAdminOrEmployee
                                @Client
                                    <a href="{{ route('scView') }}"
                                        class="dropdown-item {{ request()->is('support-contract/support-contract-view') ? ' active' : '' }}">Support
                                        Contract View</a>
                                @endClient
                            </div>
                        </div>

                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle   {{ request()->is('performance/*') ? ' active' : '' }}"
                            data-bs-toggle="dropdown"><i class="fa-solid fa-chart-simple me-2"></i>Performance</a>
                        <div
                            class="dropdown-menu  {{ request()->is('performance/*') ? ' show' : '' }} bg-transparent border-0">
                            <a href="{{ route('ScAnalysisView') }}" class="dropdown-item  {{ request()->is('performance/analysis-view') ? ' active' : '' }}">SC Analysis View</a>
                            @AdminOrEmployee
                                <a href="{{ route('employee.performanceemployee') }}"
                                    class="dropdown-item  {{ request()->is('performance/employee-performance') ? ' active' : '' }}">Employee
                                    Performance</a>

                                    <a href="{{ route('financialHealth') }}"
                                        class="dropdown-item   {{ request()->is('performance/financial-health') ? ' active' : '' }}">Financial
                                        Health</a>
                                    {{-- <a href="#" class="dropdown-item">Resource Utilization</a> --}}
                                @endAdminOrEmployee
                            </div>
                        </div>
                        <a href="{{ route('myprofile') }}"
                            class="nav-item nav-link {{ request()->is('myprofile') ? ' active' : '' }}"><i
                                class="fa-solid fa-user me-2"></i></i>My
                            Profile</a>

                        @Root
                            <div class="nav-item dropdown">
                                <a href="#"
                                    class="nav-link dropdown-toggle  {{ request()->is('permissions/*') ? ' active' : '' }}"
                                    data-bs-toggle="dropdown"><i class="fa-solid fa-gears me-2"></i>Permissions</a>
                                <div
                                    class="dropdown-menu {{ request()->is('permissions/*') ? ' show' : '' }} bg-transparent border-0">
                                    {{-- <a href="#" class="dropdown-item">Roles</a> --}}
                                    <a href="{{ route('root.permissions') }}"
                                        class="dropdown-item {{ request()->is('permissions/manage-permissions') ? ' active' : '' }}">Permissions</a>
                                    <a href="{{ route('root.modules') }}"
                                        class="dropdown-item {{ request()->is('permissions/manage-modules') ? ' active' : '' }}">Module</a>
                                    <a href="{{ route('root.modulepermission') }}"
                                        class="dropdown-item {{ request()->is('permissions/module-permission') ? ' active' : '' }}">Module
                                        Permission</a>
                                </div>
                            </div>
                        @endRoot
                        {{-- <a href="#" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
                    <a href="#" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                    <a href="#" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a> --}}

                    </div>
                </nav>
            </div>
            <!-- Sidebar End -->


            <!-- Content Start -->
            <div class="content">
                <!-- Navbar Start -->
                <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                    </a>
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <i class="fa fa-bars"></i>
                    </a>
                    {{-- <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form> --}}
                    <div class="navbar-nav align-items-center ms-auto">
                        {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div> --}}
                        {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div> --}}


                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                @if (Auth::user()->role->id == 1)
                                    <img class="rounded-circle me-lg-2" src="{{ asset('img/root.gif') }}"
                                        alt="" style="width: 40px; height: 40px;">
                                @elseif(Auth::user()->role->id == 2)
                                    <img class="rounded-circle me-lg-2" src="{{ asset('img/admin.gif') }}"
                                        alt="" style="width: 40px; height: 40px;">
                                @elseif(Auth::user()->role->id == 3)
                                    <img class="rounded-circle me-lg-2" src="{{ asset('img/employee.gif') }}"
                                        alt="" style="width: 40px; height: 40px;">
                                @else
                                    <img class="rounded-circle me-lg-2" src="{{ asset('img/user.gif') }}"
                                        alt="" style="width: 40px; height: 40px;">
                                @endif
                                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                <a href="{{ route('myprofile') }}" class="dropdown-item">My Profile</a>
                                <a href="#" class="dropdown-item">Settings</a>

                            </div>
                        </div>
                        <div class="nav-item dropdown" data-toggle="tooltip" data-bs-placement="right"
                            title="Log Out">
                            <!-- Authentication Links -->
                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif

                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item">
                                        <a id="navbarDropdown" class="nav-link" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                <i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Navbar End -->


                <!-- Blank Start -->
                <div class="container-fluid pt-4 px-4 ">
                    {{-- <div class="row vh-100 bg-light rounded">
                    <div class="col-md-6 text-center"> --}}


                    @yield('content')

                    {{--
                    </div>
                </div>
            </div> --}}
                    <!-- Blank End -->


                    {{-- <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End --> --}}
                </div>
                <!-- Content End -->


                <!-- Back to Top -->
                <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i
                        class="bi bi-arrow-up"></i></a>
            </div>

            <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="{{ asset('lib/chart/chart.min.js') }}"></script>
            <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
            <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
            <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
            <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
            <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
            <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

            <!-- Template Javascript -->
            <script src="{{ asset('js/main.js') }}"></script>


            {{-- ----------------------------------------------------- --}}
            {{-- Data Table Successfully Functioning Now --}}
            <script>
                new DataTable('#example');
            </script>

            <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">

            <script>
                $(document).ready(function() {
                    //tooltip
                    $("body").tooltip({
                        selector: '[data-toggle=tooltip]'
                    });

                    $(".modal").each(function() {
                        $(this).on("show.bs.modal", function() {
                            var easeIn = $(this).data("easein");
                            console.log("EaseIn value:", easeIn); // Log the value of easeIn variable
                            if (easeIn) {
                                console.log("Adding animation class:",
                                    easeIn); // Log that animation class is being added
                                $(this).find(".modal-dialog").addClass(" animated " + easeIn);
                            }
                        });
                    })
                });
            </script>

            <script>
                // Show and Hide Password from Password Feild
                $(document).ready(function() {
                    $("#show_hide_password a").on('click', function(event) {
                        event.preventDefault();
                        if ($('#show_hide_password input').attr("type") == "text") {
                            $('#show_hide_password input').attr('type', 'password');
                            $('#show_hide_password i').addClass("fa-eye-slash");
                            $('#show_hide_password i').removeClass("fa-eye");
                        } else if ($('#show_hide_password input').attr("type") == "password") {
                            $('#show_hide_password input').attr('type', 'text');
                            $('#show_hide_password i').removeClass("fa-eye-slash");
                            $('#show_hide_password i').addClass("fa-eye");
                        }
                    });
                });
            </script>

            <script>
                //Email validation part.
                $(document).ready(function() {
                    $("#email").on("blur", function() {
                        validateEmail();
                    });

                    function validateEmail() {
                        var email = $("#email").val();
                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (emailRegex.test(email)) {
                            // Email is valid
                            $("#emailHelp").text("Email is valid").removeClass("text-danger").addClass("text-success");
                        } else {
                            // Email is invalid
                            $("#emailHelp").text("Please enter a valid email address").removeClass("text-success").addClass(
                                "text-danger");
                        }
                    }
                });

                $(document).ready(function() {
                    $("#editEmail").on("blur", function() {
                        validateEmail();
                    });

                    function validateEmail() {
                        var email = $("#editEmail").val();
                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (emailRegex.test(email)) {
                            // Email is valid
                            $("#emailHelpedit").text("Email is valid").removeClass("text-danger").addClass("text-success");
                        } else {
                            // Email is invalid
                            $("#emailHelpedit").text("Please enter a valid email address").removeClass("text-success")
                                .addClass(
                                    "text-danger");
                        }
                    }
                });
            </script>

            <script>
                //Password validation part.
                $(document).ready(function() {
                    $("#password").on("click", function() {
                        $("#passwordValidate").text("Password should be minimum 8 characters").addClass(
                            "text-danger");
                    });
                });
            </script>

            <script>
                function validateNumberLength(input) {
                    // Set the maximum allowed length
                    var maxLength = 10;

                    // Remove any non-numeric characters
                    var phone = input.value.replace(/\D/g, '');

                    // Trim the input to the maximum length
                    var trimmedValue = phone.slice(0, maxLength);

                    // Update the input value
                    input.value = trimmedValue;
                }
            </script>

        </div>
</body>

</html>
