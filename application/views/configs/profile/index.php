<?php
if ($profile['image']) {
    $image = json_decode($profile['image']);
}
?>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"> <img src="<?= ($profile['image'] == NULL) ? base_url('assets/media/avatars/blank.png')  : 'data:image/jpeg;base64,' . $image ?>" alt="image" /> </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2"> <a href="javascript:void(0);" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $profile['name'] ?></a> </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2"> <a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"><?= $profile['role'] ?></a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Details</h3>
                </div> <a href="javascript:void(0);" id="editProfile" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
            </div>
            <div class="card-body p-9">
                <div class="row mb-7"> <label class="col-lg-4 fw-semibold text-muted">Nama</label>
                    <div class="col-lg-8"> <span class="fw-bold fs-6 text-gray-800"><?= $profile['name'] ?></span> </div>
                </div>
                <div class="row mb-7"> <label class="col-lg-4 fw-semibold text-muted">NIP.</label>
                    <div class="col-lg-8 fv-row"> <span class="fw-semibold text-gray-800 fs-6"><?= $profile['nip'] ?></span> </div>
                </div>
                <div class="row mb-7"> <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <div class="col-lg-8 fv-row"> <span class="fw-semibold text-gray-800 fs-6"><?= $profile['email'] ?></span> </div>
                </div>
                <div class="row mb-7"> <label class="col-lg-4 fw-semibold text-muted">No. Telepon</label>
                    <div class="col-lg-8 d-flex align-items-center"> <span class="fw-bold fs-6 text-gray-800 me-2"><?= $profile['phone'] ?></span> </div>
                </div>
                <div class="row mb-7"> <label class="col-lg-4 fw-semibold text-muted">Jenis Kelamin</label>
                    <div class="col-lg-8"> <span class="fw-bold fs-6 text-gray-800"><?= ($profile['gender'] == 'male') ? "Laki - laki" : "Perempuan" ?></span> </div>
                </div>
                <div class="row mb-10"> <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                    <div class="col-lg-8"> <span class="fw-semibold fs-6 text-gray-800"><?= $profile['address'] ?></span> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header py-7 d-flex justify-content-between">
                <h2 class="fw-bold m-0">Ubah Profile</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y m-5">
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <form id="editForm" class="form" action="javascript:void(0);">
                        <div class="card-body">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto Profil</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?= base_url('assets/media/avatars/blank.png') ?>')">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= ($profile['image']) ? 'data:image/jpeg;base64,' . $image  : 'assets/media/avatars/blank.png' ?>)"></div>
                                        <!-- <?php if ($profile['image']) : ?>
                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                                        <?php endif ?> -->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Ubah foto" data-bs-original-title="Ubah foto" data-kt-initialized="1">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="editAvatar" id="editAvatar" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="editAvatar_remove">
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Batalkan" data-bs-original-title="Batalkan" data-kt-initialized="1">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="form-text">format yang didukung: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6"> <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-12 fv-row">
                                            <input type="text" name="editName" id="editName" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Nama" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6"> <label class="col-lg-4 col-form-label required fw-semibold fs-6">NIP.</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="email" name="editNIP" id="editNIP" class="form-control form-control-lg form-control-solid active" readonly placeholder="Email" />
                                </div>
                            </div>
                            <div class="row mb-6"> <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="email" name="editEmail" id="editEmail" class="form-control form-control-lg form-control-solid active" readonly placeholder="Email" />
                                </div>
                            </div>
                            <div class="row mb-6"> <label class="col-lg-4 col-form-label fw-semibold fs-6"> <span class="required">Phone</span> </label>
                                <div class="col-lg-8 fv-row">
                                    <input type="tel" name="editPhone" id="editPhone" class="form-control form-control-lg mask_phone" placeholder="No. Telepon" />
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Jenis Kelamin</label>
                                <div class="col-lg-8 fv-row">
                                    <div class="d-flex align-items-center mt-3">
                                        <label class="form-check form-check-custom form-check-inline form-check-solid">
                                            <input class="form-check-input" name="editGender" type="radio" value="male" />
                                            <span class="fw-semibold ps-2 fs-6">Laki-laki</span> </label> <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" name="editGender" type="radio" value="female" />
                                            <span class="fw-semibold ps-2 fs-6">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6"> <label class="col-lg-4 col-form-label fw-semibold fs-6">Alamat</label>
                                <div class="col-lg-8 fv-row">
                                    <textarea name="editAddress" id="editAddress" class="form-control form-control-lg" id="" cols="20" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-primary" id="edit_button">Simpan Perubahan</button>
                            <input type="hidden" name="idUser">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let data = <?= json_encode($profile) ?>
</script>