<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/media/logos/icon.ico') ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/global/leaflet/leaflet.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="<?= base_url('assets/plugins/global/leaflet/leaflet.js') ?>"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <title><?= $title ?> | SIPARELNEW</title>
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on" class="app-default">
    <!--begin::Page loading(append to body)-->
    <div class="page-loader">
        <span class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
    </div>
    <!--end::Page loading-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
                <div class="d-flex flex-stack flex-grow-1">
                    <div class="d-flex align-items-center ps-lg-12" id="kt_app_header_logo">
                        <div id="kt_app_sidebar_toggle" style="background-color: #F45905;" class="app-sidebar-toggle btn btn-sm btn-icon btn-color-white w-30px h-30px ms-n2 me-4 d-none d-lg-flex" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                            <span class="svg-icon svg-icon-6">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="16" height="2" rx="1" transform="matrix(-1 0 0 1 16 0)" fill="currentColor" />
                                    <rect width="16" height="2" rx="1" transform="matrix(-1 0 0 1 16 6)" fill="currentColor" />
                                    <rect width="16" height="2" rx="1" transform="matrix(-1 0 0 1 16 12)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                    <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                        <a href="<?= base_url() ?>" class="text-white" style="font-weight: bold;">
                            <img alt="Logo" src="<?= base_url('assets/media/logos/siparel-02.png') ?>" class="h-50px">
                        </a>
                        <span class="m-2 display-6" style="color: #F45905;">SIPARELNEW</span>
                    </div>
                    <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
                        <div class="app-navbar-item ms-2 ms-lg-6" id="kt_header_user_menu_toggle">
                            <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-lg-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <?php
                                if ($session_profile['image']) {
                                    $profil_image = json_decode($session_profile['image']);
                                }
                                ?>
                                <img src="<?= ($session_profile['image']) ? 'data:image/jpeg;base64,' . $profil_image : base_url('assets/media/avatars/blank.png') ?>" alt="user" />
                            </div>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="<?= ($session_profile['image']) ? 'data:image/jpeg;base64,' . $profil_image : base_url('assets/media/avatars/blank.png') ?>" />
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5"> <?= $session_profile['name'] ?>
                                            </div>
                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?= $session_profile['role'] ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-item px-5">
                                    <a href="<?= base_url('my_profile') ?>" class="menu-link px-5">Profil Saya</a>
                                </div>
                                <div class="menu-item px-5 my-1">
                                    <a href="<?= base_url('profile-settings') ?>" class="menu-link px-5">Pengaturan Akun</a>
                                </div>
                                <div class="menu-item px-5">
                                    <a href="<?= base_url('logout') ?>" class="menu-link px-5">Keluar</a>
                                </div>
                            </div>
                        </div>
                        <div class="app-navbar-item ms-2 ms-lg-6 me-lg-5">
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div id="kt_app_sidebar" class="app-sidebar flex-column my-3" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle" style="height: 100%;">
                    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 my-lg-2" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
                        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-6 mb-5">
                            <div class="menu-item">
                                <a class="menu-link" href="<?= base_url('dashboard') ?>">
                                    <span class="menu-icon">
                                        <i class="fonticon-house fs-1"></i>
                                    </span>
                                    <span class="menu-title fs-1">Beranda</span>
                                </a>
                            </div>
                            <div class="menu-item menu-accordion">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fa-regular fa-newspaper fs-1"></i>
                                    </span>
                                    <span class="menu-title fs-1">Laporan</span>
                                </span>
                                <div class="menu-sub menu-sub-accordion show">
                                    <div class="menu-item">
                                        <a class="menu-link" href="<?= base_url('news-report') ?>" title="Laporan Relawan" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot fs-1"></span>
                                            </span>
                                            <span class="menu-title fs-1">Laporan Relawan</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="<?= base_url('search-area') ?>" title="Cari Area" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot fs-1"></span>
                                            </span>
                                            <span class="menu-title fs-1">Cari Area</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="<?= base_url('news-recap') ?>" title="Rekap Laporan" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot fs-1"></span>
                                            </span>
                                            <span class="menu-title fs-1">Rekap Laporan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-item menu-accordion">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fonticon-setting fs-1"></i>
                                    </span>
                                    <span class="menu-title fs-1">Konfigurasi</span>
                                </span>
                                <div class="menu-sub menu-sub-accordion show">
                                    <div class="menu-item">
                                        <a class="menu-link" href="<?= base_url('volunteers-management') ?>" title="Pengaturan Relawan" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot fs-1"></span>
                                            </span>
                                            <span class="menu-title fs-1">Pengaturan Relawan</span>
                                        </a>
                                    </div>
                                    <?php if ($session_profile['role'] == 'superadmin' || $session_profile['role'] == 'admin') : ?>
                                        <div class="menu-item">
                                            <a class="menu-link" href="<?= base_url('users-management') ?>" title="Pengaturan Pengguna" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot fs-1"></span>
                                                </span>
                                                <span class="menu-title fs-1">Pengaturan Pengguna</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <!-- <div class="menu-item">
                                        <a class="menu-link" href="<?= base_url('groups-management') ?>" title="Pengaturan Grup" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot fs-1"></span>
                                            </span>
                                            <span class="menu-title fs-1">Pengaturan Grup</span>
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-main flex-column flex-row-fluid kt_blockui_target m-5" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">