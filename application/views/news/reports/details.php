<?php $base64Images = json_decode($details['image'], true); ?><div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-body p-lg-17">
                <div class="row mb-3">
                    <div class="col-md-12 d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex my-4">
                            <?php if ($details['status'] == 'waiting') : ?>
                                <span class="badge badge-light-primary fs-1"><b>Belum dipublikasi</b></span>
                            <?php elseif ($details['status'] == 'published') : ?>
                                <span class="badge badge-light-success fs-1"><b>Dipublikasi</b></span>
                            <?php endif ?>
                        </div>
                        <div class="d-flex my-4">
                            <?php if ($details['status'] == 'waiting') :  ?>
                                <div class="mx-3">
                                    <button class="btn btn-active-warning" style="background-color: #F45905;" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="publishButton">
                                        <i class="fa-solid fa-upload text-white fs-3"></i>
                                        <b class="text-white fs-3">Publikasikan</b>
                                    </button>
                                </div>
                            <?php endif ?>
                            <div class="me-0">
                                <button class="btn btn-active-warning" style="background-color: #F45905;" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="fa-solid fa-ellipsis-vertical text-white fs-3"></i>
                                    <b class="text-white fs-3">Opsi</b>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" class="menu-link px-3" id="editReport">
                                            <span class="menu-icon">
                                                <i class="fa-solid fa-pen-to-square fs-3"></i>
                                            </span>
                                            <span class="menu-title fs-3">
                                                Ubah Laporan
                                            </span>
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a class="menu-link" href="javascript:void(0);" id="deleteReport">
                                            <span class="menu-icon">
                                                <i class="fa-solid fa-trash fs-3"></i>
                                            </span>
                                            <span class="menu-title fs-3">
                                                Hapus Laporan
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pe-lg-10 mb-5">
                        <div id="data_report">
                            <h1 class="fw-bold text-dark mb-9">Detali Laporan</h1>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                    <label class="fs-5 fw-semibold mb-2">Nama Relawan:</label>
                                    <input type="text" class="form-control form-control-solid" readonly value="<?= $details['volunteer_name'] ?>">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                    <label class="fs-5 fw-semibold mb-2">Tanggal Upload:</label>
                                    <input type="text" class="form-control form-control-solid" readonly value="<?= $details['upload_timestamp'] ?>">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Judul Laporan</label>
                                <input class="form-control form-control-solid" readonly value="<?= $details['title'] ?>">
                            </div>
                            <div class="d-flex flex-column mb-10 fv-row fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold mb-2">Detail</label>
                                <textarea class="form-control form-control-solid" readonly rows="10" name="message" style="resize: none;"><?= $details['content'] ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div id="edit_report" style="display: none;">
                            <form id="form_edit" class="form" action="javascript:void(0)">
                                <h1 class="fw-bold text-dark mb-9">Ubah Laporan</h1>
                                <div class="row mb-5">
                                    <div class="col-md-12 fv-row fv-plugins-icon-container">
                                        <label class="fs-5 fw-semibold mb-2">Judul Laporan</label>
                                        <input class="form-control" name="edit_reportTitle" value="<?= $details['title'] ?>">
                                    </div>
                                    <div class="col-md-12 fv-row fv-plugins-icon-container">
                                        <label class="fs-6 fw-semibold mb-2">Detail</label>
                                        <textarea class="form-control" rows="10" name="edit_reportContent" style="resize: none;"><?= $details['content'] ?></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-danger btn-active-light-danger mx-3" id="cancel_edit">
                                        <b class="fs-3">Batal</b>
                                    </button>
                                    <button class="btn btn-active-warning" id="submit_edit" style="background-color: #2A1A5E;">
                                        <b class="text-white fs-3">Simpan</b>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-flush h-xl-100">
                            <div class="card-body py-9">
                                <div class="row gx-9 h-100">
                                    <div class="col-sm-12 mb-10 mb-sm-0">
                                        <div id="kt_carousel_3_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="8000" style="height: 486px; position: relative;">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                                    <?php foreach ($base64Images as $key => $base64Image) : ?>
                                                        <li data-bs-target="#kt_carousel_3_carousel" data-bs-slide-to="<?= $key ?>" class="ms-1<?= ($key === 0 ? ' active' : '') ?>"></li>
                                                    <?php endforeach; ?>
                                                </ol>
                                            </div>
                                            <div class="carousel-inner pt-8">
                                                <?php foreach ($base64Images as $key => $base64Image) : ?>
                                                    <div class="carousel-item<?= ($key === 0 ? ' active' : '') ?>">
                                                        <a class="d-block overlay h-100" data-fancybox="gallery" data-src="data:image/jpg;base64,<?= $base64Image ?>">
                                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px h-100" style="background-image:url(data:image/jpg;base64,<?= $base64Image ?>)"></div>
                                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div id="kt_contact_map" class="ps-lg-10 w-100 rounded mb-2 mb-lg-0 mt-2 leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" style="height: 486px; position: relative;" tabindex="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let data = <?php echo json_encode($details); ?>;
</script>