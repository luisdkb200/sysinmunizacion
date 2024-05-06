<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Inventario Vacunas</title>
    <link rel="shortcut icon" type="image/ico" href="{{ asset('dist/img/logogsrb2.png') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">

    {{-- <link rel="stylesheet" href="{{asset('plugins/sweetalerts/sweetalert.css')}}" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-lightblue">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ asset('configuracion/mi_perfil') }}"
                            class="dropdown-header">{{ auth()->user()->name }}<br>
                        </a>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('login') }}">
                            @method('put')
                            @csrf
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i></button>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-lightblue elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link bg-lightblue">
                @if (!empty($empresa_ini->logoEmp))
                    <img src="{{ asset('empresas/' . $empresa_ini->logoEmp) }}" alt="logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                @endif
                <span class="brand-text font-weight-light">
                    <font style="font-weight: bold; font-size: 0.8em;">{{ $empresa_ini->nomEmp }}</font>
                </span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{-- @if (auth()->user()->imageUsers != '')
                            <img src="{{ asset('users/' . auth()->user()->imageUsers) }}"
                                class="img-circle elevation-2" alt="Image">
                        @endif --}}
                    </div>
                    <div class="info">
                        <span class="d-block text-white">
                            @php($nombre = explode(' ', auth()->user()->name))
                            @if (count($nombre) > 1)
                                {{ $nombre[0] }} {{ $nombre[1] }}
                            @else
                                {{ auth()->user()->name }}
                            @endif
                        </span>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ asset('panel_control') }}"
                                class="nav-link
                                {{ 'panel_control' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Panel de Control
                                </p>
                            </a>
                        </li>


                        <li
                            class="nav-item {{ 'inicio' == request()->segment(1) && 'panel_control' != request()->segment(2) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'inicio' == request()->segment(1) && 'panel_control' != request()->segment(2) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Operaciones
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ asset('inicio/entrega_vacunas') }}"
                                        class="nav-link {{ 'entrega_vacunas' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Entrega de Vacunas</p>
                                    </a>
                                </li>


                                {{-- <li class="nav-item">
                                    <a href="{{ asset('inicio/devolucion') }}"
                                        class="nav-link {{ 'devolucion' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Devolución</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ asset('inicio/mantenimiento') }}"
                                        class="nav-link {{ 'mantenimiento' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Mantenimiento</p>
                                    </a>
                                </li> --}}

                            </ul>
                        </li>

                        {{-- <li class="nav-item {{ 'equipo' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ 'equipo' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    Equipo
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ asset('equipo/equipos') }}"
                                        class="nav-link {{ 'equipos' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Equipos</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ asset('equipo/categoria') }}"
                                        class="nav-link {{ 'categoria' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Categoría</p>
                                    </a>
                                </li>

                            </ul>
                        </li> --}}


                        <li class="nav-item {{ 'registro' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'registro' == request()->segment(1) ? 'active' : '' }}">
                                <!-- <i class="nav-icon fas fa-store"></i> -->
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Registro
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ asset('registro/vacuna') }}"
                                        class="nav-link {{ 'vacuna' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Vacunas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('registro/jeringa') }}"
                                        class="nav-link {{ 'jeringa' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Jeringas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('registro/saldo_vacuna') }}"
                                        class="nav-link {{ 'saldo_vacuna' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Saldo de Vacunas</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ asset('registro/establecimiento') }}"
                                        class="nav-link {{ 'establecimiento' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Establecimientos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('registro/poblacion') }}"
                                        class="nav-link {{ 'poblacion' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Poblacion</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ 'reporte' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'reporte' == request()->segment(1) ? 'active' : '' }}"
                                style="background: ">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Reporte
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ asset('reporte/vale') }}"
                                        class="nav-link {{ 'vale' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Vales</p>
                                    </a>
                                </li>

                                {{-- <li class="nav-item">
                                    <a href="{{ asset('reporte/general') }}"
                                        class="nav-link {{ 'general' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>General</p>
                                    </a>
                                </li> --}}

                            </ul>
                            <!-- <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/mantenimientos') }}"
                                            class="nav-link {{ 'mantenimientos' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon text-info"></i>
                                            <p>Mantenimientos</p>
                                        </a>
                                    </li>
                                </ul> -->

                        </li>


                        <li class="nav-item {{ 'acceso' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'acceso' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>
                                    Acceso
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('acceso/usuario') }}"
                                        class="nav-link {{ 'usuario' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Usuario</p>
                                    </a>
                                </li>



                            </ul>
                        </li>


                        <li class="nav-item {{ 'configuracion' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Configuración
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/ajustes') }}"
                                        class="nav-link {{ 'ajustes' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Ajustes</p>
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
            <!-- Content Header (Page header) -->
            @yield('encabezado')
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->

        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">

            <strong>Copyright &copy; 2023 <a href="#">CADENA DE FRIO</a>.</strong>
            Todos los derechos Reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>SISTEMA PARA EL CONTROL DE ENTREGA DE BIOLOGICOS </b>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-select.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    {{-- Data tables --}}
    <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/chart.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('dist/js/eliminar.js') }}"></script>
    <script src="{{ asset('dist/js/anular.js') }}"></script>

    <script>
        $('.decimales').on('input', function() {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
        $('.enteros').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
        });
    </script>
</body>

</html>
