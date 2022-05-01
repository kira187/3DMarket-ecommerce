<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard/assets/images/logo-light-icon.png') }}">
    <title>Inicio</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('dashboard/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    @yield('css')
    <!-- Custom CSS -->
    <link href="{{ asset('dashboard/css/css/style.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" />

    <link href="{{ asset('dashboard/css/colors/green-dark.css') }}" id="theme" rel="stylesheet">
    
    @livewireStyles
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand text-center" href="index.html">
                        <b>
                            <img src="{{ asset('dashboard/assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                        </b>
                        <span class="text-white font-weight-bold">
                            Tienda CUCEI
                        </span>
                    </a>
                </div>
                
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->profile_photo_url }}"" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('profile.show') }}">
                                            <i class="ti-user"></i>
                                            Mi Perfil
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fa fa-power-off"></i>
                                                Cerrar Sesión
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        
        @include('layouts.menuLayout')
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('Breadcrumb')
                <div class="row">
                    <div class="col-12">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            <footer class="footer">
                Universidad de Guadalajara © 2022
            </footer>
        </div>
    </div>
    
    @stack('modals')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('dashboard/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('dashboard/assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('dashboard/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src=" {{ asset('dashboard/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dashboard/js/sidebarmenu.js') }}"></script>
    {{-- IziToast --}}
    <script src="{{ asset('vendor/iziToast/js/iziToast.min.js')}}"></script>
    {{-- Ckeditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
    {{-- Sweat alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--stickey kit -->
    <script src="{{ asset('dashboard/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
    <!-- dropzone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('scripts')
    @stack('script')
    <script src="{{ asset('dashboard/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <script>
        window.addEventListener('alert', event => { 
           iziToast[event.detail.type]({
                title: event.detail.title ?? 'Aviso',
                message: event.detail.message,
                position: 'topRight',
            }); 
        });
    </script>
</body>
</html>
