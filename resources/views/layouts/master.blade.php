
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>e-Library Management System</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="app">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="user-panel h-auto py-0 nav-link" data-toggle="dropdown">
                        <img
                            src="{{ Auth::user()->user_image == null ? '/img/profile.jpg' : '/img/'.auth()->user()->user_image }}"
                            class="img-circle elevation-2"
                            id="user_profile_picture"
                            alt="User Image"
                        >
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <router-link to="/settings" class="dropdown-item">
                            <i class="fas fa-cog mr-1"></i> Settings
                        </router-link>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                            <i class="fas fa-sign-out-alt mr-1"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <img src="/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">IETI Library</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="/img/{{ Auth::user()->user_image }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                            @php
                                $items = array(
                                    // text        Link    Icon            Class
                                    "Dashboard" => ["/", "tachometer-alt", ""],
                                    "Attendance" => ["/attendance", "clipboard-list", ""],
                                    "Book Entry" => ["/book-entry", "book", ""],
                                    "Issued & Return" => ["/issued-return", "paste", ""],
                                    "Borrowers" => ["/borrowers", "book-reader", ""],
                                    "User Management" => ["/user-management", "users-cog", ""],
                                    "Audit Log" => ["/audit-log", "history", ""],
                                    "Reports" => ["/reports", "file-download", ""],
                                );
                            @endphp

                            @foreach ($items as $item => [$link, $icon, $class])
                                <li class="nav-item">
                                    <router-link to="{{ $link }}" class="nav-link {{ $class }}">
                                        <i class="nav-icon fas fa-{{ $icon }}"></i>
                                        <p>{{ $item }}</p>
                                    </router-link>
                                </li>
                            @endforeach

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <br>

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <router-view></router-view>
                        <vue-progress-bar></vue-progress-bar>
                    </div>
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <script src="/js/app.js"></script>
    </body>
</html>
