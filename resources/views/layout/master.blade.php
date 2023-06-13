<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="token" content="{{ csrf_token() }}"/>
        
        <title>CAOL - Controle de Atividades Online - Agence Interativa</title>

        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

        <!-- Nucleo Icons -->
        <link href="{{ asset('material-kit/assets/css/material-kit.css') }}" rel="stylesheet" />
        <link href="{{ asset('material-kit/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <!-- CSS Files -->



        <link id="pagestyle" href="{{ asset('material-kit/assets/css/material-kit.css?v=3.0.4') }}" rel="stylesheet" />

    </head>
    <body>
        <!-- Navbar Light -->
        <nav
        class="navbar navbar-expand-lg navbar-light bg-white z-index-3 py-3">
        <div class="container">
            <a class="navbar-brand" href="" rel="tooltip" title="Controle de Atividades Online - Agence Interativa" data-placement="bottom" target="_blank">
                CAOL
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
            </button>
            <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav navbar-nav-hover mx-auto">
                <li class="nav-item px-3">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                        <i class="material-icons opacity-6 me-2 text-md">home</i>
                        Agence
                    </a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                        <i class="material-icons opacity-6 me-2 text-md">checklist</i>
                        Projetos
                    </a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                        <i class="material-icons opacity-6 me-2 text-md">list_alt</i>
                        Administrativo
                    </a>
                </li>

                <li class="nav-item px-3 dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons opacity-6 me-2 text-md">group</i>
                        Comercial
                        <img src="{{ asset('material-kit/assets/img/down-arrow-dark.svg') }}" alt="down-arrow" class="arrow ms-auto ms-md-2">
                    </a>
                    <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                        <div class="d-none d-lg-block">
                            <a href="{{ route('desempenho') }}" class="dropdown-item border-radius-md">
                                <span>Performance Comercial</span>
                            </a>
                        </div>

                        <div class="d-lg-none">
                            <a href="{{ route('desempenho') }}" class="dropdown-item border-radius-md">
                                <span>Performance Comercial</span>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                        <i class="material-icons opacity-6 me-2 text-md">payments</i>
                        Financeiro
                    </a>
                </li>

                <li class="nav-item px-3 dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuUsuario" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons opacity-6 me-2 text-md">person</i>
                        Usuário
                        <img src="{{ asset('material-kit/assets/img/down-arrow-dark.svg') }}" alt="down-arrow" class="arrow ms-auto ms-md-2">
                    </a>
                    <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3" aria-labelledby="dropdownMenuUsuario">
                        <div class="d-none d-lg-block">
                            <a href="{{ route('index') }}" class="dropdown-item border-radius-md ps-2 d-flex cursor-pointer align-items-center">
                                <i class="material-icons opacity-6 me-2 text-md">close</i>
                                <span>Salir</span>
                            </a>
                        </div>

                        <div class="d-lg-none">
                            <a href="{{ route('index') }}" class="dropdown-item border-radius-md ps-2 d-flex cursor-pointer align-items-center">
                                <i class="material-icons opacity-6 me-2 text-md">close</i>
                                <span>Salir</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <img src="{{ asset('sitio/logo.gif') }}" alt="" class="img-fluid mx-auto d-block">
            </ul>
            </div>
        </div>
        </nav>
        <!-- End Navbar -->
    <section>
        @yield("contenedor")
    </section>
    <!--   Core JS Files   -->
    <script src="{{ asset('material-kit/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('material-kit/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('material-kit/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>




    <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="{{ asset('material-kit/assets/js/plugins/countup.min.js') }}"></script>





    <script src="{{ asset('material-kit/assets/js/plugins/choices.min.js') }}"></script>



    <script src="{{ asset('material-kit/assets/js/plugins/prism.min.js') }}"></script>
    <script src="{{ asset('material-kit/assets/js/plugins/highlight.min.js') }}"></script>



    <!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
    <script src="{{ asset('material-kit/assets/js/plugins/rellax.min.js') }}"></script>
    <!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
    <script src="{{ asset('material-kit/assets/js/plugins/tilt.min.js') }}"></script>
    <!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
    <script src="{{ asset('material-kit/assets/js/plugins/choices.min.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
