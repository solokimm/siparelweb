<div class="d-flex flex-column flex-root" id="kt_app_root">
    <style>
        body {
            background-image: url("<?= base_url('assets/media/auth/bg10.jpeg') ?>");
        }
    </style>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-lg-row-fluid">
            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                <!-- <img src="<?= base_url('assets/media/auth/agency.png') ?>" alt="" /> -->
                <div class="mx-auto">
                    <div id="3dLogo" style="width: 400px; height: 400px;"></div>
                </div>
                <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Sistem Informasi Pelaporan Relawan</h1>
                <!-- <div class="text-gray-600 fs-base text-center fw-semibold">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br>
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, <br>
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. <br>
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. <br>
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,<br>
                    and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div> -->
            </div>
        </div>
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <div class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20">
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="javascript:void(0);">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Masuk Ke SIPARELNEW</h1>
                            </div>
                            <div class="fv-row mb-8"> <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" /> </div>
                            <div class="fv-row mb-3"> <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" /> </div>
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="javascript:void(0);" class="link-primary">Lupa Password ?</a>
                            </div>
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Masuk</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>