<x-laravel-ui-adminlte::adminlte-layout>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('img/pp_user.jpg') }}"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="{{ asset('img/pp_user.jpg') }}"
                                    class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Anggota sejak {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="{{route('backend.profil')}}" class="btn btn-default btn-flat">Profil</a>
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper py-4 px-2">
                 <!-- Dynamic Page Header -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>@yield('page-title', 'Default Title')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                @yield('breadcrumb')
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>



                @yield('content')
            </div>

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- <div class="float-right d-none d-sm-block">
                    <b>Version</b> 3.1.0
                </div>
                <strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
                reserved. -->
                <strong>Copyright &copy; <a target="_BLANK" href="https://spbe.denpasarkota.go.id">SPBE Kominfos Kota Denpasar</a>.</strong>
            </footer>
        </div>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
