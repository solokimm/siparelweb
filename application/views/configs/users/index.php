<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-1 m-0">Daftar Penyuluh</h1>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                </svg>
                            </span>
                            Filter
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Pengaturan Filter</div>
                            </div>
                            <div class="separator border-gray-200"></div>
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <div class="mb-10">
                                    <label class="required form-label fs-6 fw-semibold">Role</label>
                                    <select class="form-select" id="filterRole" data-kt-select2="true" data-placeholder="Pilih Peranan" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                                        <option></option>
                                        <option value="superadmin">Superadmin</option>
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Status</label>
                                    <select class="form-select" id="filterStatus" data-kt-select2="true" data-placeholder="Pilih Status" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                                        <option></option>
                                        <option value="active">Aktif</option>
                                        <option value="nonactive">Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" id="reset_filter">Reset</button>
                                    <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter" id="apply_filter">Filter</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_users">
                            <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                </svg>
                            </span>
                            Tambah Penyuluh
                        </button>
                        <div class="modal fade" id="kt_modal_add_users" aria-hidden="true" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <div class="modal-header" id="kt_modal_add_user_header">
                                        <h2 class="fw-bold">Tambah Penyuluh</h2>
                                    </div>
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                        <form id="addUser" class="form" action="javascript:void(0)">
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll">
                                                <div class="row g-9 mb-8" data-select2-id="select2-data-137-soyn">
                                                    <div class="col-md-6 fv-row">
                                                        <label class="required fs-6 fw-semibold mb-2">Nama</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <input class="form-control" placeholder="Wahyu Pramono" id="uName" name="uName" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 fv-row">
                                                        <label class="required fs-6 fw-semibold mb-2">NIP.</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <input class="form-control" placeholder="1975xxxxxxxxxxxxxx" id="uNip" name="uNip" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 fv-row">
                                                        <label class="required fs-6 fw-semibold mb-2">Email</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <input class="form-control mask_email" placeholder="example@email.com" id="uEmail" name="uEmail" type="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 fv-row">
                                                        <label class="required form-label fs-6 fw-semibold">Peranan</label>
                                                        <select class="form-select" name="uRole" id="uRole" data-kt-select2="true" data-placeholder="Pilih Peranan" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                                                            <option></option>
                                                            <option value="superadmin">Superadmin</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="supervisor">Supervisor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="required form-label fs-6 fw-semibold">Satker</label>
                                                        <select class="form-select" id="uSatker" name="uSatker">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center pt-15">
                                                <a href="javascript:void(0);" id="cancelInvite" class="btn btn-danger me-3">Batal</a>
                                                <button type="submit" id="btn_invite" class="btn btn-primary">
                                                    <span class="indicator-label">Undang</span>
                                                    <span class="indicator-progress">Sedang proses... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" id="search-input" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Penyuluh" />
                </div>
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_users">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Nama</th>
                            <th class="min-w-125px">Asal Satker</th>
                            <th class="min-w-125px">Peranan</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Login Terakhir</th>
                            <th class="text-end min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold"> </tbody>
                </table>
            </div>
        </div>
    </div>
</div>