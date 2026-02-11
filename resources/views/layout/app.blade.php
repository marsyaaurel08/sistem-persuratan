<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="flexilecode" />
    <!--! The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags !-->
    <!--! BEGIN: Apps Title-->
    <title>Sistem Persuratan || @yield('title')</title>

    <!--! END:  Apps Title-->
    <!--! BEGIN: Favicon-->

    <link rel="shortcut icon" type="image/x-icon"
        href="https://eproc.jasatirta1.co.id/assets/images/logo-jasatirta-crop.png" />
    <!--! END: Favicon-->
    <!--! BEGIN: Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}" />
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!--! END: Bootstrap Icons -->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/daterangepicker.min.css') }}" />
    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/badge.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">



    <!--! END: Custom CSS-->
    <!--! BEGIN: Custom App CSS-->

    <!--! END: Custom App CSS-->
    <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
    <!--! WARNING: Respond.js doesn't work if you view the page via file: !-->
    <!--[if lt IE 9]>
			<script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    @stack('styles')
</head>

<body>
    <!--! ================================================================ !-->
    <!--! [Start] Navigation Manu !-->
    <!--! ================================================================ !-->
    @include('layout.navbar')
    <!--! ================================================================ !-->
    <!--! [End]  Navigation Manu !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! [Start] Header !-->
    <!--! ================================================================ !-->
    <header class="nxl-header">
        <div class="header-wrapper">
            <!--! [Start] Header Left !-->
            @include('layout.header')
            <!--! [End] Header Right !-->
        </div>
    </header>
    <!--! ================================================================ !-->
    <!--! [End] Header !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="nxl-container">

        <div class="nxl-content">
            <!-- [ page-header ] start -->



            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->

            <div class="main-content">
                <div class="row">
                    @yield('content')
                    @stack('scripts')

                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        @include('layout.footer')
        <!-- [ Footer ] end -->
    </main>

    <div class="modal fade" id="modalLogout" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="feather-log-out fs-24" style="color: #000B58;"></i>
                    </div>
                    <h6 class="fw-bold mb-2" style="color: #000B58;">Konfirmasi Keluar</h6>
                    <p class="text-secondary small mb-4">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
                    <div class="d-grid gap-2">
                        <a href="/logout" class="btn rounded-pill text-white" style="background-color: #000B58;">
                            Ya, Keluar
                        </a>
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Theme Customizer !-->
    <!--! ================================================================ !-->
    {{-- <div class="theme-customizer">
        <div class="customizer-handle">
            <a href="javascript:void(0);" class="cutomizer-open-trigger bg-primary">
                <i class="feather-settings"></i>
            </a>
        </div>
        <div class="customizer-sidebar-wrapper">
            <div
                class="customizer-sidebar-header px-4 ht-80 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Theme Settings</h5>
                <a href="javascript:void(0);" class="cutomizer-close-trigger d-flex">
                    <i class="feather-x"></i>
                </a>
            </div>
            <div class="customizer-sidebar-body position-relative p-4" data-scrollbar-target="#psScrollbarInit">
                <!--! BEGIN: [Navigation] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Navigation</label>
                    <div class="row g-2 theme-options-items app-navigation" id="appNavigationList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-light" name="app-navigation"
                                value="1" data-app-navigation="app-navigation-light" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-navigation-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-dark" name="app-navigation"
                                value="2" data-app-navigation="app-navigation-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-navigation-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Navigation] !-->
                <!--! BEGIN: [Header] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set mt-5">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Header</label>
                    <div class="row g-2 theme-options-items app-header" id="appHeaderList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-light" name="app-header" value="1"
                                data-app-header="app-header-light" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-header-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-dark" name="app-header" value="2"
                                data-app-header="app-header-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-header-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Header] !-->
                <!--! BEGIN: [Skins] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Skins</label>
                    <div class="row g-2 theme-options-items app-skin" id="appSkinList">
                        <div class="col-6 text-center position-relative single-option light-button active">
                            <input type="radio" class="btn-check" id="app-skin-light" name="app-skin" value="1"
                                data-app-skin="app-skin-light" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-skin-light">Light</label>
                        </div>
                        <div class="col-6 text-center position-relative single-option dark-button">
                            <input type="radio" class="btn-check" id="app-skin-dark" name="app-skin" value="2"
                                data-app-skin="app-skin-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-skin-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Skins] !-->
                <!--! BEGIN: [Typography] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-0 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Typography</label>
                    <div class="row g-2 theme-options-items font-family" id="fontFamilyList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-lato" name="font-family" value="1"
                                data-font-family="app-font-family-lato" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-lato">Lato</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-rubik" name="font-family"
                                value="2" data-font-family="app-font-family-rubik" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-rubik">Rubik</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-inter" name="font-family"
                                value="3" data-font-family="app-font-family-inter" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-inter">Inter</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-cinzel" name="font-family"
                                value="4" data-font-family="app-font-family-cinzel" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-cinzel">Cinzel</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-nunito" name="font-family"
                                value="6" data-font-family="app-font-family-nunito" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-nunito">Nunito</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto" name="font-family"
                                value="7" data-font-family="app-font-family-roboto" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-roboto">Roboto</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ubuntu" name="font-family"
                                value="8" data-font-family="app-font-family-ubuntu" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ubuntu">Ubuntu</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-poppins" name="font-family"
                                value="9" data-font-family="app-font-family-poppins" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-poppins">Poppins</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-raleway" name="font-family"
                                value="10" data-font-family="app-font-family-raleway" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-raleway">Raleway</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-system-ui" name="font-family"
                                value="11" data-font-family="app-font-family-system-ui" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-system-ui">System UI</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-noto-sans" name="font-family"
                                value="12" data-font-family="app-font-family-noto-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-noto-sans">Noto Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-fira-sans" name="font-family"
                                value="13" data-font-family="app-font-family-fira-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-fira-sans">Fira Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-work-sans" name="font-family"
                                value="14" data-font-family="app-font-family-work-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-work-sans">Work Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-open-sans" name="font-family"
                                value="15" data-font-family="app-font-family-open-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-open-sans">Open Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-maven-pro" name="font-family"
                                value="16" data-font-family="app-font-family-maven-pro" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-maven-pro">Maven Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-quicksand" name="font-family"
                                value="17" data-font-family="app-font-family-quicksand" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-quicksand">Quicksand</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat" name="font-family"
                                value="18" data-font-family="app-font-family-montserrat" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat">Montserrat</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-josefin-sans" name="font-family"
                                value="19" data-font-family="app-font-family-josefin-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-josefin-sans">Josefin Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ibm-plex-sans" name="font-family"
                                value="20" data-font-family="app-font-family-ibm-plex-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ibm-plex-sans">IBM Plex Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-source-sans-pro"
                                name="font-family" value="5" data-font-family="app-font-family-source-sans-pro" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-source-sans-pro">Source Sans Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat-alt" name="font-family"
                                value="21" data-font-family="app-font-family-montserrat-alt" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat-alt">Montserrat Alt</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto-slab" name="font-family"
                                value="22" data-font-family="app-font-family-roboto-slab" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-roboto-slab">Roboto Slab</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Typography] !-->
            </div>
            <div class="customizer-sidebar-footer px-4 ht-60 border-top d-flex align-items-center gap-2">
                <div class="flex-fill w-50">
                    <a href="javascript:void(0);" class="btn btn-danger" data-style="reset-all-common-style">Reset</a>
                </div>
                <div class="flex-fill w-50">
                    <a href="https://www.themewagon.com/themes/Duralux-admin" target="_blank"
                        class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div> --}}
    <!--! ================================================================ !-->
    <!--! [End] Theme Customizer !-->
    <!--! ================================================================ !-->
    
    @stack('modals')

    <!--! ================================================================ !-->
    <!--! Footer Script !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Vendors JS !-->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/circle-progress.min.js') }}"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="{{ asset('duralux/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/js/dashboard-init.min.js') }}"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="{{ asset('duralux/assets/js/theme-customizer-init.min.js') }}"></script>
    <!--! END: Theme Customizer !-->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <div id="toastNotif" class="toast-notif">
        <span class="toast-icon"></span>
        <span class="toast-message"></span>
        <button class="toast-close">&times;</button>
    </div> --}}


    {{-- ✅ TOAST NOTIFICATION GLOBAL --}}
    <div id="toastNotif" class="toast-notif">
        <span class="toast-icon"></span>
        <span class="toast-message"></span>
        <button class="toast-close">&times;</button>
    </div>

    <style>
        /* ==== Toast Modern Style ==== */
        .toast-notif {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            max-width: 360px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.95rem;
            background: #fff;
            color: #333;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 6px solid;
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.4s ease;
            z-index: 9999;
        }

        .toast-notif.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-success {
            border-color: #28a745;
            background-color: #e8f5e9;
        }

        .toast-info {
            border-color: #0d6efd;
            background-color: #e7f0ff;
        }

        .toast-warning {
            border-color: #ffc107;
            background-color: #fff8e1;
        }

        .toast-error {
            border-color: #dc3545;
            background-color: #fdecea;
        }

        .toast-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .toast-close {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #666;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #000;
        }
    </style>

    <script>
        // === Global Toast Function ===
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotif');
            if (!toast) return;

            const icon = toast.querySelector('.toast-icon');
            const msg = toast.querySelector('.toast-message');
            const closeBtn = toast.querySelector('.toast-close');

            toast.className = `toast-notif toast-${type}`;
            msg.textContent = message;

            const icons = {
                success: '<i class="feather-check-circle text-success"></i>',
                info: '<i class="feather-info text-primary"></i>',
                warning: '<i class="feather-alert-triangle text-warning"></i>',
                error: '<i class="feather-x-circle text-danger"></i>',
            };
            icon.innerHTML = icons[type] || icons.success;

            toast.classList.add('show');
            setTimeout(() => hideToast(), 3000);
            closeBtn.onclick = hideToast;
        }

        function hideToast() {
            const toast = document.getElementById('toastNotif');
            if (toast) toast.classList.remove('show');
        }

        // === Auto tampilkan toast dari session Laravel ===
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
});
    </script>

  
    @stack('scripts')

@yield('scripts')
</body>

</html>