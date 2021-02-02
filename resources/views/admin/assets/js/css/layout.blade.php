@php

    use Illuminate\Support\Facades\Storage;
    use App\Support\Cropper;
    use Illuminate\Support\Facades\Auth;

@endphp
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

    <title>Admin</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/fontawesome-free/css/all.min.css')) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/adminlte.min.css')) }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/responsive.bootstrap4.min.css')) }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('css')
        @yield('css')
    @endif
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-th-large"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        src="{{ !empty(Auth::user()->cover) ? Storage::url(Cropper::thumb(Auth::user()->cover,200)) : asset('backend/assets/img/avatar5.png') }}"
                        class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info">
                    <a href="{{route('admin.home')}}" class="d-block">{{Auth::user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.home')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Clientes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.users.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ver Todos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.companies.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Empresas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.users.team')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Time</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.users.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Criar Novo</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Imóveis
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.properties.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ver Todos</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.properties.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Criar Novo</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="{{route('admin.contracts.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Contratos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.contracts.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ver Todos</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.contracts.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Criar Novo</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 <a href="https://edsonlimacode.com.br">Edson Lima</a></strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset(mix('backend/assets/js/jquery.min.js')) }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset(mix('backend/assets/js/bootstrap.bundle.min.js')) }}"></script>
<!-- DataTables -->
<script src="{{ asset(mix('backend/assets/js/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/dataTables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/responsive.bootstrap4.min.js')) }}"></script>
<script src="{{ asset('backend/assets/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset(mix('backend/assets/js/jquery.mask.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/scripts.js')) }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset(mix('backend/assets/js/adminlte.min.js')) }} "></script>
@hasSection('js')
    @yield('js')
@endif

<script>
    $(function () {
        $('#data-table').DataTable();
    });

</script>
</body>

</html>
