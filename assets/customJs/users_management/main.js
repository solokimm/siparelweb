/* begin:: Users Table */
var table = $('table#table_users').DataTable({
	paging: true,
	responsive: true,
	searchDelay: 500,
	serverSide: true,
	processing: true,
	pageLength: 5,
	lengthMenu: [
		[5, 10, 25, 50, 100, -1],
		[5, 10, 25, 50, 100, 'All'],
	],
	language: {
		emptyTable: 'Tidak ada data tersedia',
		info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
		infoEmpty: 'Menampilkan 0 - 0 dari 0 data',
	},
	ajax: {
		url: `${base_url}users-management/table`,
		dataType: 'JSON',
		data: function (data) {
			data.status = $('select#filterStatus').val() ? $('select#filterStatus').val() : 'all';
			data.role = $('select#filterRole').val() ? $('select#filterRole').val() : 'all';
		},
	},
	order: [[0, 'asc']],
	columns: [
		{ data: 'name' },
		{ data: 'satker_name' },
		{
			data: 'role',
			render: function (data, type, row) {
				if (data == 'superadmin') {
					return `<span class="mx-2 badge badge-info">Super Admin</span>`;
				} else if (data == 'admin') {
					return `<span class="mx-2 badge badge-primary">Admin</span>`;
				} else if (data == 'supervisor') {
					return `<span class="mx-2 badge badge-success">Penyuluh</span>`;
				}
			},
		},
		{
			data: 'status',
			render: function (data, type, row) {
				if (data == 'active') {
					return `<span class="badge py-3 px-4 fs-7 badge-light-primary">Aktif</span>`;
				} else if (data == 'nonactive') {
					return `<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>`;
				}
			},
		},
		{
			data: 'last_login',
			render: function (data, type, row) {
				let time = moment(data).calendar();

				return time;
			},
		},
		{
			data: 'id',
			class: 'text-center',
			orderable: false,
			render: function (data, type, row) {
				let button = ``;
				if (data != 0) {
					button = `
					<a href="${base_url}users-management/details/${data}" id="editUser" class="btn btn-sm btn-primary btn-clean btn-icon btn-icon-md">
					<i class="fa-solid fa-circle-info"></i>
					</a>
					<a href="javascript:void(0);" id="deleteUser" data-id="${data}" data-name="${row.name}" class="btn btn-sm btn-primary btn-clean btn-icon btn-icon-md" data-nik="">
						<i class="fa fa-trash"></i>
					</a>
					`;
				}
				return button;
			},
		},
	],
});

$('input#search-input').on('keyup', function () {
	table.search(this.value).draw();
});
/* end:: Users Table */

/* begin:: Filter */
$('button#apply_filter').click(function () {
	table.ajax.reload();
});

$('button#reset_filter').click(function () {
	$('select#filterRole').val(null).trigger('change');
	$('select#filterStatus').val(null).trigger('change');
	table.ajax.reload();
});
/* end:: Filter */

/* begin:: Random Pass */
function getRandom_Pass() {
	var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	var randomString = '';

	for (var i = 0; i < 8; i++) {
		var randomIndex = Math.floor(Math.random() * characters.length);
		randomString += characters.charAt(randomIndex);
	}
	return randomString;
}
/* end:: Random Pass */

/* begin:: Add */
function formInvite() {
	let submitButton = $('#btn_invite');
	let form = $('form#addUser')[0];
	let fv = FormValidation.formValidation(form, {
		fields: {
			uName: {
				validators: {
					notEmpty: {
						message: 'Masukan nama lengkap penyuluh',
					},
				},
			},
			uNip: {
				validators: {
					notEmpty: {
						message: 'Masukan NIP penyuluh',
					},
				},
			},
			uEmail: {
				validators: {
					notEmpty: {
						message: 'Masukan email penyuluh',
					},
					emailAddress: {
						message: 'Alamat email tidak valid',
					},
				},
			},
			uRole: {
				validators: {
					notEmpty: {
						message: 'Pilih peranan penyuluh',
					},
				},
			},
			uSatker: {
				validators: {
					notEmpty: {
						message: 'Pilih asal satker',
					},
				},
			},
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5(),
			submitButton: new FormValidation.plugins.SubmitButton(),
			fieldStatus: new FormValidation.plugins.FieldStatus({
				onStatusChanged: function (areFieldsValid) {
					areFieldsValid ? submitButton.attr('disabled', false) : submitButton.attr('disabled', true);
				},
			}),
		},
	});

	submitButton.click(function () {
		fv.validate().then(function (status) {
			if (status === 'Valid') {
				blockUI.block();
				$.ajax({
					url: `${base_url}users-management/add`,
					type: 'POST',
					data: {
						name: $('input#uName').val(),
						nip: $('input#uNip').val(),
						email: $('input#uEmail').val(),
						role: $('select#uRole').val(),
						satker_id: $('select#uSatker').val(),
						password: getRandom_Pass(),
					},
					dataType: 'JSON',
					success: function (response) {
						if (response.status === 'success') {
							setTimeout(function () {
								$('#uRole').val(null).trigger('change');
								$('#uSatker').val(null).trigger('change');
								fv.resetForm();
								form.reset();
								toastr.success(response.message);
								blockUI.release();
								table.ajax.reload();
								submitButton.attr('disabled', false);
								$('div#kt_modal_add_users').modal('hide');
							}, 2500);
						} else if (response.status === 'invalid') {
							toastr.warning(response.message);
							blockUI.release();
						}
					},
				});
			} else {
				toastr.warning('Terdapat inputan yang belum valid!');
			}
		});
	});

	$('#cancelInvite').click(function () {
		form.reset();
		fv.resetForm();
		$('select#uRole').val(null).trigger('change');
		$('select[name="uSatker"]').val(null).trigger('change');
		$('div#kt_modal_add_users').modal('hide');
		submitButton.attr('disabled', false);
	});
	$('select[name="uSatker"]').on('select2:select', function () {
		fv.revalidateField('uSatker');
	});
	$('select[name="uRole"]').on('change', function () {
		fv.revalidateField('uRole');
	});
}
formInvite();
/* $('form#addUser').submit(function () {
	$('#btn_invite').attr('data-kt-indicator', 'on');
	$('#btn_invite').prop('disabled', true);
	$('#cancelAdd').addClass('d-none');
	$.ajax({
		url: `${base_url}users-management/add`,
		type: 'POST',
		dataType: 'JSON',
		data: {
			name: $('input#uName').val(),
			email: $('input#uEmail').val(),
			satker_id: $('select#uSatker').val(),
			role: $('select#uRole').val(),
			password: getRandom_Pass(),
		},
		success: function (response) {
			if (response.status == 'success') {
				$('#btn_invite').attr('data-kt-indicator', 'off');
				$('#btn_invite').prop('disabled', false);
				$('#cancelAdd').removeClass('d-none');
				$('div#kt_modal_add_users').modal('hide');
				$('select#uRole').val(null).trigger('change');
				$('select#uSatker').val(null).trigger('change');
				$('form#addUser')[0].reset();
				toastr.success(response.message);
				table.ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$('#btn_invite').attr('data-kt-indicator', 'off');
			$('#btn_invite').prop('disabled', false);
			$('#cancelAdd').removeClass('d-none');
			swal.fire({
				type: 'error',
				title: 'Error',
				html: jqXHR.responseText,
			});
		},
	});
}); */

$('a#cancelAdd').click(function () {
	$('div#kt_modal_add_users').modal('hide');
	$('select#uRole').val(null).trigger('change');
	$('form#addUser')[0].reset();
});
/* end:: Add */

/* begin:: Delete */
$(document).on('click', 'a#deleteUser', function () {
	let id = $(this).data('id'),
		name = $(this).data('name');
	swal
		.fire({
			title: `Hapus Pengguna <b>${name}</b> ?`,
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: `Batal`,
			confirmButtonColor: 'red',
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `${base_url}users-management/delete`,
					type: 'POST',
					data: {
						id: id,
					},
					dataType: 'JSON',
					success: function (response) {
						if (response.status == 'success') {
							toastr.success(response.message);
							table.ajax.reload();
						} else {
							swal.fire({
								icon: 'error',
								text: response.message,
							});
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						swal.fire({
							type: 'error',
							title: 'Error',
							html: jqXHR.responseText,
						});
					},
				});
			}
		});
});
/* end:: Delete */

/* begin:: Select Satker */
$('select[name="uSatker"]').select2({
	dropdownParent: $('#kt_modal_add_users'),
	placeholder: 'Pilih',
	ajax: {
		url: 'users-management/select2_satker',
		dataType: 'json',
		delay: 250,
		processResults: function (data) {
			return {
				results: $.map(data, function (item) {
					return {
						id: item.id,
						text: item.text,
					};
				}),
			};
		},
		cache: true,
	},
});
/* end:: Select Satker */
