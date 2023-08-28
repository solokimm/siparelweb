<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Kata Sandi dan Email</h3>
                </div>
            </div>
            <div id="kt_account_settings_signin_method" class="collapse show">
                <div class="card-body border-top p-9">
                    <div class="d-flex flex-wrap align-items-center">
                        <div id="kt_signin_email" class="">
                            <div class="fs-6 fw-bold mb-1">Email</div>
                            <div class="fw-semibold text-gray-600">
                                <span id="currEmail"><?= $profile['email'] ?></span>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-light btn-active-light-primary" id="editEmail">Ubah Email</button>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-6"></div>
                    <div id="kt-edit-email" style="display: none;">
                        <div class="d-flex flex-wrap align-items-center">
                            <div id="kt_signin_email_edit" class="flex-row-fluid">
                                <form id="changeEmail_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="javascript:void(0);">
                                    <div class="row mb-6">
                                        <div class="col-lg-4 mb-4 mb-lg-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="newEmailAddress" name="newEmailAddress" placeholder="Masukan Email Baru" />
                                                <label for="newEmailAddress"><b class="text-muted">Masukan Email Baru</b></label>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi Kata Sandi" />
                                                <label for="confirmPassword"><b class="text-muted">Konfirmasi Kata Sandi</b></label>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button id="cahngeEmail_submit" type="submit" class="btn btn-primary me-2 px-6">Simpan Perubahan</button>
                                        <!-- <button id="kt_editEmail_cancel" type="button" class="btn btn-light-danger btn-active-danger px-6">Batal</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-6"></div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div id="kt_signin_password" class="">
                            <div class="fs-6 fw-bold mb-1">Kata Sandi</div>
                            <div class="fw-semibold text-gray-600">************</div>
                        </div>
                        <div id="kt_signin_password_button" class="ms-auto">
                            <button id="changePass" class="btn btn-light btn-active-light-primary">Ubah Kata Sandi</button>
                        </div>
                    </div>
                    <div id="kt-change-pass" style="display: none;">
                        <div class="separator separator-dashed my-6"></div>
                        <div id="kt_signin_password_edit" class="flex-row-fluid">
                            <form id="changePass_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="javascript:void(0);">
                                <div class="row mb-1">
                                    <div class="col-lg-4">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="currPassword" name="currPassword" placeholder="Kata Sandi Lama" />
                                            <label for="currPassword"><b class="text-muted">Kata Sandi Lama</b></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Kata Sandi Baru" />
                                            <label for="newPassword"><b class="text-muted">Kata Sandi Baru</b></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Konfirmasi Kata Sandi Baru" />
                                            <label for="confirmNewPassword"><b class="text-muted">Konfirmasi Kata Sandi Baru</b></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-text mb-5">
                                    Kondisi Password
                                </div> -->
                                <div class="d-flex">
                                    <button id="changePass_submit" type="submit" class="btn btn-primary me-2 px-6">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Nonaktifkan Akun</h3>
                </div>
            </div>
            <div id="kt_account_settings_deactivate" class="collapse show">
                <form id="changeStatus_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="javascript:void(0);">
                    <div class="card-body border-top p-9">
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6"> <span class="svg-icon svg-icon-2tx svg-icon-warning me-4"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                </svg> </span>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Akun anda akan dinonaktifkan</h4>
                                    <div class="fs-6 text-gray-700">
                                        Untuk keamanan, diperlukan untuk mengkonfirmasi bahwa anda setuju untuk menonaktifkan akun anda. <br>
                                        Untuk mengaktifkan nya kembali hubungi blablablabla
                                        <!-- <a class="fw-bold" href="#">Learn more</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-check-solid fv-row fv-plugins-icon-container">
                            <input name="confirmCheckBox" class="form-check-input" type="checkbox" value="agree" id="confirmCheckBox">
                            <label class="form-check-label fw-semibold ps-2 fs-6" for="confirmCheckBox">Saya setuju</label>
                            <div class="fv-plugins-message-container invalid-feedback checKMessage d-none">
                                <b>*Harap Centang Untuk Melanjutkan</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button id="changeStatus_submit" type="submit" class="btn btn-danger fw-semibold">Nonaktifkan Akun</button>
                        <input type="hidden">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>