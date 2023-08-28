<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-1">Cari Area</h1>
        <div class="row row g-5 g-xl-10 mb-5">
            <div class="col-xl-12">
                <div class="card card-flush h-md-100">
                    <div id="search_area_maps" style="height: 650px"></div>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5">
            <form id="kt_search_area_form" class="form" action="javascript:void(0)">
                <div class="row g-9 mb-8" data-select2-id="select2-data-137-soyn">
                    <div class="col-md-4 fv-row"> <label class="fs-3 fw-semibold mb-2">Lokasi</label> <input type="text" id="latlng" class="text-center form-control form-control-solid" disabled /> </div>
                    <div class="col-md-3 fv-row"> <label class="form-label fs-3 fw-semibold">Radius Pencarian (meter)</label>
                        <div class="position-relative d-flex align-items-center"> <input type="text" id="radius" class="form-control form-control-solid" value="0" /> </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end fv-row"> <button type="submit" id="startSearch" class="btn btn-primary"> <span class="indicator-label">Cari</span> <span class="indicator-progress">Mencari <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span> </button> </div>
                </div>
            </form>
        </div>
    </div>
    <div class="app-container container-fluid" style="display: none;" id="detailCard">
        <div class="card h-xl-100">
            <div class="card-header">
                <h3 class="card-title">Detail Laporan</h3>
            </div>
            <div class="card-body">
                <div class="row h-100" id="detailReport">
                    <h1 class="text-center text-muted"><em><strong>Klik pada titik lokasi untuk melihat detail laporan</strong></em></h1>
                    <!-- <div class="col-sm-6 mb-10 mb-sm-0">
                        <div id="kt_carousel_3_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="8000">
                            <div class="d-flex align-items-center justify-content-center flex-wrap">
                                <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                    <li data-bs-target="#kt_carousel_3_carousel" data-bs-slide-to="0" class="ms-1 active"></li>
                                </ol>
                            </div>
                            <div class="carousel-inner pt-8">
                                <div class="carousel-item active">
                                    <a class="d-block overlay h-100" data-fancybox="gallery" data-src="<?= base_url('assets/media/illustrations/dozzy-1/1.png') ?>">
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px h-100" style="background-image:url(<?= base_url('assets/media/illustrations/dozzy-1/1.png') ?>)"></div>
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-7">
                                <div class="mb-6">
                                    <span class="text-gray-400 fs-3 fw-bold me-2 d-block lh-1 pb-1">${value['location_lat']}, ${value['location_lng']}</span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                                    <div class="d-flex align-items-center me-5 me-xl-13">
                                        <div class="symbol symbol-100px symbol-circle me-3"> <img src="assets/media/avatars/300-3.jpg" class="" alt=""> </div>
                                        <div class="m-0"> <span class="fw-bold text-gray-800 text-hover-primary fs-3 info_VolunteerName">${value['uploaded_by']}</span> <span class="fw-semibold text-gray-400 d-block fs-4 info_UploadedTime">${value['upload_timestamp']}</span> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column border border-1 border-gray-300 p-6 mb-8 card-rounded">
                                <span class="fw-bold text-gray-800 fs-1 lh-1 pb-1 info_Title">${value['title']}</span>
                                <span class="fw-semibold text-gray-600 fs-3 pb-1 info_Content">${value['content']}</span>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>