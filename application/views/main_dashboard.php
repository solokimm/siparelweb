<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5">
            <div class="col-xl-4">
                <!--begin::Total Relawan-->
                <div class="card card-xl">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-warning rounded p-5">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="me-5">
                                <i class="fa-solid fa-users text-warning fs-2"></i>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2 text-center">
                                <a href="javascript:void(0);" class="fw-bold text-gray-800 text-hover-primary fs-6">Total Relawan</a>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-warning py-1 fs-2 countVolu">0</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Total Relawan-->
            </div>

            <div class="col-xl-4">
                <!--begin::Total Laporan-->
                <div class="card card-xl">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-success rounded p-5">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="me-5">
                                <i class="fa-solid fa-clipboard-list text-success fs-2"></i>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2 text-center">
                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Total Laporan</a>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-success py-1 fs-2 countReports">0</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Total Laporan-->
            </div>
        </div>
        <!--end::Row -->

        <div class="row g-5 g-xl-10 mb-5">
            <div class="col-xl-4">
                <!--begin::Leaderboard-->
                <div class="card card-xl mb-xl-8">
                    <div class="card-header border-0 text-center">
                        <h3 class="card-title fw-bold text-dark">Relawan Terbaik</h3>
                    </div>
                    <div class="card-body pt-2 leaderBoard">
                    </div>
                </div>
                <!--end::Leaderboard-->
            </div>
            <!-- begin::MapsChart -->
            <div class="col-xl-8">
                <div class="card card-flush" style="height: 500px; ">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Relawan Indonesia</span>
                        </h3>
                    </div>
                    <div class="card-body d-flex flex-center">
                        <div id="volunteer_maps" class="h-100 w-100"></div>
                    </div>
                </div>
            </div>
            <!-- begin::Maps -->
        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->