<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Controle | Finanças</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/fontawesome-free/css/all.min.css')) }}">
    @notifyCss

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/adminlte.min.css')) }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/responsive.bootstrap4.min.css')) }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/style.css')) }}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('notify::messages')
    <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown show">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <i class="fas fa-wallet"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <span class="dropdown-item dropdown-header">Controle</span>
                    @php
                        $wallets = \App\Models\Wallet::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();
                    @endphp
                    @foreach($wallets as $wallet)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('control.wallet-control',['wallet_id'=>$wallet->id])}}"
                           class="dropdown-item wallet-control">
                            <i class="fas fa-wallet mr-2"></i> {{$wallet->name}} {!!  (session('wallet') == $wallet->id ? '<i style="color: #03f55d" class="ml-3 fa fa-check"></i>' : '') !!}
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-cog"></i></a>
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
                @php
                    if(\Illuminate\Support\Facades\Auth::user()->cover):
                        $cover = \Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->cover);
                        else:
                        $cover = asset('backend/assets/img/cover-default.png');
                    endif
                @endphp
                <div class="image">
                    <img src="{{$cover}}" class="img-circle elevation-2"
                         alt="User Image" style="width: 50px; height: 50px">
                </div>
                <div class="info">
                    <a href="{{route('control.app')}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->first_name
                                                                        .' '.\Illuminate\Support\Facades\Auth::user()->last_name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{route('control.wallets.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Carteiras
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('control.invoice',['type' => 'expense'])}}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-alt"></i>
                            <p>
                                Pagar
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('control.invoice',['type' => 'income'])}}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-alt"></i>
                            <p>
                                Receber
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('control.fixed')}}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                            <p>
                                Fixas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('control.users.edit',['user'=>\Illuminate\Support\Facades\Auth::user()->id])}}"
                           class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Perfil
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('control.signout')}}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Sair
                            </p>
                        </a>
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

            <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="py-4 px-3">
            @php
                if(\Illuminate\Support\Facades\Auth::user()->cover):
                    $cover = \Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->cover);
                    else:
                    $cover = asset('backend/assets/img/cover-default.png');
                endif
            @endphp
            <div class="image aside-img text-center">
                <img src="{{$cover}}" class="img-circle elevation-2"
                     alt="User Image" style="width: 100%; max-height: 100px;">
                <h5 class="mt-3"><a
                        href="{{route('control.users.edit',['user'=>\Illuminate\Support\Facades\Auth::user()->id])}}">Editar
                        perfil</a></h5>
            </div>

            <ul class="list-unstyled">
                <li>
                    <p>Nome:
                        <small>{{\Illuminate\Support\Facades\Auth::user()->first_name .' '
                                       .\Illuminate\Support\Facades\Auth::user()->last_name}}
                        </small>
                    </p>
                    <p>Email: <small>{{\Illuminate\Support\Facades\Auth::user()->email}}</small></p>
                    <p>Plano: <small
                            class="badge badge-success">{{\Illuminate\Support\Facades\Auth::user()->premium == 0 ? 'free' : 'premium'}}</small>
                    </p>
                    <p>Acesso: <small
                            class="badge badge-primary">{{\Illuminate\Support\Facades\Auth::user()->level == 0 ? 'usuário' : 'admin'}}</small>
                    </p>
                </li>
            </ul>
            <a href="{{route('control.signout')}}" class="btn btn-danger "><i class="fa fa-edit mr-2"></i>Sair</a>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer d-flex justify-content-center">
        <!-- Default to the left -->
        <small style="color: #343a40!important" class="font-weight-bold">&copy; Todos os direitos reservados - Feito com
            <i class="fa fa-heart"></i> por mim</small>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset(mix('backend/assets/js/jquery.min.js')) }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset(mix('backend/assets/js/bootstrap.bundle.min.js')) }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset(mix('backend/assets/js/adminlte.min.js')) }} "></script>
<!-- jQuery -->
<script src="{{ asset(mix('backend/assets/js/jquery.mask.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/dataTables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('backend/assets/js/responsive.bootstrap4.min.js')) }}"></script>

<script src="{{ asset(mix('backend/assets/js/scripts.js')) }}"></script>
@notifyJs
@hasSection('js')
    @yield('js')
@endif

</body>
</html>
