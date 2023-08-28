<div id="kt_app_content" class="app-content flex-column-fluid">
	<div id="kt_app_content_container" class="app-container container-fluid">
		<div class="card mb-5 mb-xl-10">
			<div class="card-body pt-9 pb-0">
				<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
					<div class="me-7 mb-4">
						<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
							<img src="<?= ($profile['image'] == NULL ? base_url('assets/media/avatars/blank.png') : json_decode($profile['image'])) ?>">
							<input type="hidden" id="idVolunteer" value="<?= $profile['id'] ?>">
						</div>
					</div>
					<div class="flex-grow-1">
						<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
							<div class="d-flex flex-column">
								<div class="d-flex align-items-center"> <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $profile['name'] ?></a> </div>
								<div class="fw-semibold fs-6 text-gray-400"><?= $profile['group_name'] ?></div>
							</div>
							<div class="d-flex">
								<div class="me-0"> <button class="btn btn-sm btn-icon btn-warning btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> <i class="bi bi-three-dots fs-3"></i> </button>
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
										<div class="menu-item px-3"> <a href="javascript:void(0)" id="editVolunteer" class="menu-link px-3">Ubah</a> </div>
										<div class="menu-item px-3"> <a href="javascript:void(0)" id="deleteVolunteer" class="menu-link flex-stack px-3">Hapus</a> </div>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex flex-wrap flex-stack my-5">
							<div class="d-flex flex-column flex-grow-1 pe-8">
								<div class="d-flex flex-wrap">
									<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
										<div class="d-flex align-items-center">
											<div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1"><?= $profile['total_reports'] ?></div>
										</div>
										<div class="fw-semibold fs-6 text-gray-400">Laporan</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
			<div class="card-header cursor-pointer">
				<div class="card-title m-0">
					<h3 class="fw-bold m-0">Detail Profil</h3>
				</div>
			</div>
			<div class="card-body p-9">
				<div class="row mb-7">
					<label class="col-lg-4 fw-semibold">NIK.</label>
					<div class="col-lg-8">: <span class="fw-bold fs-6"><?= $profile['nik'] ?></span> </div>
				</div>
				<div class="row mb-7"> <label class="col-lg-4 fw-semibold">Email</label>
					<div class="col-lg-8">: <span class="fw-bold fs-6"><?= $profile['email'] ?></span> </div>
				</div>
				<div class="row mb-7"> <label class="col-lg-4 fw-semibold">No. Telepon</label>
					<div class="col-lg-8 d-flex align-items-center">: <span class="fw-bold fs-6 me-2"><?= $profile['phone'] ?></span></div>
				</div>
				<div class="row mb-7"> <label class="col-lg-4 fw-semibold">Alamat</label>
					<div class="col-lg-8">: <span class="fw-bold fs-6"><?= $profile['address'] ?></span> </div>
				</div>
				<div class="row mb-7"> <label class="col-lg-4 fw-semibold">Jenis Kelamin</label>
					<div class="col-lg-8">: <span class="fw-bold fs-6"><?= ($profile['gender'] == NULL ? '-' : ($profile['gender'] == 'male' ? "Laki - laki" : "Perempuan")) ?></span> </div>
				</div>
				<div class="row mb-10"> <label class="col-lg-4 fw-semibold">Tempat Tanggal Lahir</label>
					<div class="col-lg-8">: <span class="fw-semibold fs-6"><?= ($profile['place_ofbirth'] ? $profile['place_ofbirth'] : '-') . ", " .  ($profile['date_ofbirth'] ? $profile['date_ofbirth'] : '-') ?></span> </div>
				</div>
				<div class="row mb-10"> <label class="col-lg-4 fw-semibold">Status</label>
					<div class="col-lg-8">: <?= ($profile['status'] == 'active' ? '<span class="badge badge-success fs-3 ">Aktif</span>' : '<span class="badge badge-danger fs-3 ">Nonaktif</span>') ?> </div>
				</div>
			</div>
		</div>

		<div class="card mb-xl-10" style="display: none;" id="edit_details">
			<div class="card-header cursor-pointer">
				<div class="card-title m-0">
					<h3 class="fw-bold m-0">Ubah Profil</h3>
				</div>
			</div>
			<div class="card-body p-9">
				<form id="form_edit" class="form" action="javascript:void(0)">
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_nik" class="col-md-4 col-form-label">NIK.</label>
						<div class="col-md-6">
							<input type="text" class="form-control form-control-solid active" readonly id="edit_nik">
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_email" class="col-md-4 col-form-label">Email</label>
						<div class="col-md-6">
							<input type="text" class="form-control form-control-solid active mask_email" readonly id="edit_email">
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_name" class="col-md-4 col-form-label">Nama Lengkap</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="edit_name" id="edit_name">
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_phone" class="col-md-4 col-form-label">No. Telepon</label>
						<div class="col-md-6">
							<input type="text" class="form-control mask_phone" name="edit_phone" id="edit_phone">
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_address" class="col-md-4 col-form-label">Alamat</label>
						<div class="col-md-6">
							<textarea class="form-control" name="edit_address" id="edit_address" rows="6"></textarea>
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_gender" class="col-md-4 col-form-label">Jenis Kelamin</label>
						<div class="col-md-6">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="edit_gender" value="male">
								<label class="form-check-label" for="edit_gender">Laki - laki</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="edit_gender" value="female">
								<label class="form-check-label" for="edit_gender">Perempuan</label>
							</div>
						</div>
					</div>
					<div class="form-group row mb-3 fv-row fv-plugins-icon-container">
						<label for="edit_placeOfbirth" class="col-md-4 col-form-label">Tempat Lahir</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="edit_placeOfbirth" id="edit_placeOfbirth">
						</div>
					</div>
					<div class="form-group row mb-5 fv-row fv-plugins-icon-container">
						<label for="edit_dateOfbirth" class="col-md-4 col-form-label">Tanggal Lahir</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="edit_dateOfbirth" id="edit_dateOfbirth">
						</div>
					</div>
					<div class="form-group row mb-9">
						<label for="edit_status" class="col-md-4 col-form-label">Status</label>
						<div class="col-md-6">
							<div class="form-check form-switch form-check-custom form-check-solid form-check-success">
								<input class="form-check-input w-60px" type="checkbox" checked id="edit_status" />
								<label class="form-check-label" for="edit_status">
									<span class="badge fs-3 status_lable"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-start">
						<a class="btn btn-danger btn-active-light-danger mx-3" id="cancel_edit">
							<b class="fs-3">Batal</b>
						</a>
						<button class="btn btn-active-warning" id="submit_edit" style="background-color: #2A1A5E;">
							<b class="text-white fs-3">Simpan</b>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	let data = <?= json_encode($profile) ?>
</script>