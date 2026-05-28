<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />

<style>
    .swal2-container {
        z-index: 9999;
    }

    /* Theme color customization based on Apotek Rizki logo */
    :root {
        --bs-primary: #0c8a8a !important;
        --bs-primary-rgb: 12, 138, 138 !important;
        --bs-link-color: #0c8a8a !important;
        --bs-link-hover-color: #0a7070 !important;
        --bs-primary-border-color: #0c8a8a !important;
        --bs-purple: #0c8a8a !important;
    }

    /* Primary buttons */
    .btn-primary {
        background-color: #0c8a8a !important;
        border-color: #0c8a8a !important;
        box-shadow: 0 0.125rem 0.25rem 0 rgba(12, 138, 138, 0.4) !important;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
        background-color: #0a7070 !important;
        border-color: #0a7070 !important;
        box-shadow: 0 0.125rem 0.25rem 0 rgba(10, 112, 112, 0.4) !important;
    }

    /* Outlined buttons */
    .btn-outline-primary {
        color: #0c8a8a !important;
        border-color: #0c8a8a !important;
    }
    .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
        background-color: #0c8a8a !important;
        color: #fff !important;
    }

    /* Text & background utilities */
    .text-primary {
        color: #0c8a8a !important;
    }
    .bg-primary {
        background-color: #0c8a8a !important;
    }
    .border-primary {
        border-color: #0c8a8a !important;
    }
    .bg-label-primary {
        background-color: rgba(12, 138, 138, 0.16) !important;
        color: #0c8a8a !important;
    }

    /* Active sidebar menu items (gradient) */
    .menu-vertical .menu-item.active > .menu-link:not(.menu-toggle) {
        background-image: linear-gradient(72.47deg, #0c8a8a 22.16%, rgba(12, 138, 138, 0.7) 76.47%) !important;
        color: #fff !important;
        box-shadow: 0px 2px 6px 0px rgba(12, 138, 138, 0.48) !important;
    }
    .menu-vertical .menu-item.active > .menu-link:not(.menu-toggle) i {
        color: #fff !important;
    }

    /* Dropdown active item */
    .dropdown-item.active, .dropdown-item:active {
        background-color: #0c8a8a !important;
        color: #fff !important;
    }

    /* Input borders and shadows on focus */
    .form-control:focus, .form-select:focus {
        border-color: #0c8a8a !important;
        box-shadow: 0 0 0.25rem 0.05rem rgba(12, 138, 138, 0.25) !important;
    }

    /* Waves effect */
    .waves-effect.waves-primary .waves-ripple {
        background: rgba(12, 138, 138, 0.3) !important;
    }

    /* Badges */
    .badge.bg-primary {
        background-color: #0c8a8a !important;
    }
</style>
