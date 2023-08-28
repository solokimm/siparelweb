/* begin:: table volunteer */
var table = $('table#table_volunteers').DataTable({
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
		url: `${base_url}volunteers-management/table`,
		dataType: 'JSON',
		data: function (data) {
			data.status = $('select#filterStatus').val() ? $('select#filterStatus').val() : 'all';
			data.group = $('select#filterGroup').val() ? $('select#filterGroup').val() : 'all';
		},
	},
	order: [[0, 'asc']],
	columns: [
		{ data: 'name' },
		{ data: 'username' },
		{ data: 'group_name' },
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
				return `
				  <a href="${base_url}volunteers-management/details/${data}" class="btn btn-sm btn-warning btn-clean btn-icon btn-icon-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Relawan">
				  	<i class="fa-solid fa-circle-info"></i>
				  </a>
				  <a href="javascript:void(0);" id="deleteVolunteer" data-id="${data}" data-name="${row.name}" class="btn btn-sm btn-warning btn-clean btn-icon btn-icon-md">
					  <i class="fa fa-trash"></i>
				  </a>
				  `;
			},
		},
	],
});

$('input#search-input').on('keyup', function () {
	table.search(this.value).draw();
});

$('button#apply_filter').click(function () {
	table.ajax.reload();
});

$('button#reset_filter').click(function () {
	$('select#filterStatus').val(null).trigger('change');
	$('select#filterGroup').val(null).trigger('change');
	table.ajax.reload();
});
/* end:: table volunteer */

function generate_password() {
	var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	var randomString = '';

	for (var i = 0; i < 8; i++) {
		var randomIndex = Math.floor(Math.random() * characters.length);
		randomString += characters.charAt(randomIndex);
	}
	return randomString;
}

function formInvite() {
	let submitButton = $('#inviteButton');
	let form = $('form#addVolunteer')[0];
	let fv = FormValidation.formValidation(form, {
		fields: {
			vName: {
				validators: {
					notEmpty: {
						message: 'Masukan nama lengkap relawan',
					},
				},
			},
			vNik: {
				validators: {
					notEmpty: {
						message: 'Masukan NIK relawan',
					},
				},
			},
			vEmail: {
				validators: {
					notEmpty: {
						message: 'Masukan email relawan',
					},
					emailAddress: {
						message: 'Alamat email tidak valid',
					},
				},
			},
			vUsername: {
				validators: {
					notEmpty: {
						message: 'Masukan username relawan',
					},
				},
			},
			vPhone: {
				validators: {
					notEmpty: {
						message: 'Masukan nomor telepon relawan',
					},
				},
			},
			select2_group: {
				validators: {
					notEmpty: {
						message: 'Pilih grup untuk relawan',
					},
				},
			},
			select2_city: {
				validators: {
					message: 'Pilih opsi kedua jika opsi pertama dipilih',
					callback: (function () {
						let prov = $('select2_prov').val();
						if (prov !== '' && prov !== null) {
							return $('#select2').val() !== '';
						}
						return true;
					})(),
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
		let cityXprov = (function () {
			let selectProv = $('select[name="select2_prov"]').select2('data'),
				selectCity = $('select[name="select2_city"]').select2('data');

			if (selectProv.length > 0 && selectCity.length > 0) {
				let data = `${selectCity[0].text}, ${selectProv[0].text}`;
				return data;
			}
			return false;
		})();
		fv.validate().then(function (status) {
			if (status === 'Valid') {
				blockUI.block();
				$.ajax({
					url: `${base_url}volunteers-management/invite`,
					type: 'POST',
					data: {
						data: {
							name: $('input#vName').val(),
							nik: $('input#vNik').val(),
							email: $('input#vEmail').val(),
							username: $('input#vUsername').val(),
							phone: $('input#vPhone').val(),
							group_id: $('select#vGroup').val(),
							address: cityXprov ? $('textarea#vAddress').val() + `, ${cityXprov}` : $('textarea#vAddress').val(),
							province_code: $('select#vProv').val() ? '' : '',
							city_code: $('select#vCity').val() ? '' : '',
							password: generate_password(),
						},
					},
					dataType: 'JSON',
					success: function (response) {
						if (response.status === 'success') {
							setTimeout(function () {
								$('#vProv').val(null).trigger('change');
								$('#vCity').val(null).trigger('change');
								$('#vGroup').val(null).trigger('change');
								fv.resetForm();
								form.reset();
								toastr.success(response.message);
								blockUI.release();
								table.ajax.reload();
								submitButton.attr('disabled', false);
								$('div#kt_modal_add_volunteer').modal('hide');
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
		$('select[name="select2_prov"]').val(null).trigger('change');
		$('select[name="select2_city"]').val(null).attr('disabled', true).trigger('change');
		$('select[name="select2_group"]').val(null).trigger('change');
		$('div#kt_modal_add_volunteer').modal('hide');
		form.reset();
		fv.resetForm();
		submitButton.attr('disabled', false);
	});

	$('select[name="select2_group"]').select2({
		dropdownParent: $('#kt_modal_add_volunteer'),
	});
	$('select[name="select2_group"]').on('select2:select', function () {
		if ($(this).data('form') == 'invite') {
			fv.revalidateField('select2_group');
		}
	});
	$('select[name="select2_prov"]').on('select2:select', function () {
		if ($(this).data('form') == 'invite') {
			fv.updateFieldStatus('select2_city', 'notEmpty', 'callback', {
				message: 'Pilih kota/kabupaten',
			});
			fv.revalidateField('select2_prov');
			fv.revalidateField('select2_city');
		} else if ($(this).data('form') == 'edit') {
			fvEdit.revalidateField('select2_city');
		}
	});
	$('select[name="select2_city"]').on('select2:select', function () {
		if ($(this).data('form') == 'invite') {
			if ($(this).data('form') == 'invite') {
				fv.revalidateField('select2_prov');
				fv.revalidateField('select2_city');
			}
		}
	});
	$('select[name="select2_subdistrict"]').on('select2:select', function () {
		if ($(this).data('form') == 'invite') {
			if ($(this).data('form') == 'invite') {
				fv.revalidateField('select2_prov');
				fv.revalidateField('select2_city');
			}
		}
	});
}
formInvite();

$('select[name="select2_group"]').select2({
	dropdownParent: $('#kt_modal_add_volunteer'),
	ajax: {
		url: 'volunteers-management/select2_groups',
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
	placeholder: 'Pilih Grup',
});

$('select[name="select2_prov"]')
	.select2({
		dropdownParent: $('#kt_modal_add_volunteer'),
		ajax: {
			url: 'volunteers-management/select2_prov',
			dataType: 'JSON',
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
		placeholder: 'Provinsi',
	})
	.on('select2:select', function (e) {
		let data = e.params.data;
		$('select[name="select2_city"]').val(null).trigger('change').empty();
		load_city(data.id);
	});

function load_city(prov) {
	$('select[name="select2_city"]')
		.select2({
			placeholder: 'Kota/kabupaten',
			dropdownParent: $('#kt_modal_add_volunteer'),
			ajax: {
				url: `${base_url}volunteers-management/select2_city`,
				type: 'GET',
				dataType: 'JSON',
				data: function (params) {
					var query = {
						quest: params.term,
						prov: prov,
					};
					return query;
				},
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
		})
		.on('select2:select', function (e) {
			let data = e.params.data;
		});
	prov ? $('select[name="select2_city"]').prop('disabled', false) : $('select[name="select2_city"]').prop('disabled', true);
}
/* end:: invite volunteer */

/* begin:: delete volunteer */
$(document).on('click', 'a#deleteVolunteer', function () {
	let id = $(this).data('id'),
		name = $(this).data('name');

	swal
		.fire({
			title: `Hapus Relawan <b>${name}</b> ?`,
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: `Batal`,
			confirmButtonColor: 'red',
		})
		.then((result) => {
			if (result.isConfirmed) {
				blockUI.block();
				$.ajax({
					url: `${base_url}volunteers-management/delete`,
					type: 'POST',
					data: {
						id: id,
					},
					dataType: 'JSON',
					success: function (response) {
						if (response.status == 'success') {
							toastr.success(response.message);
							table.ajax.reload();
							blockUI.release();
						} else {
							swal.fire({
								icon: 'error',
								text: response.message,
							});
							blockUI.release();
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						swal.fire({
							type: 'error',
							title: 'Error',
							html: jqXHR.responseText,
						});
						blockUI.release();
					},
				});
			}
		});
});
/* end:: Delete volunteer */

/* begin:: edit volunteer */
$(document).on('click', 'a#editVolunteer', function () {
	let id = $(this).data('id');
	$.ajax({
		url: `${base_url}volunteers-management/voluById`,
		type: 'POST',
		data: { id: id },
		dataType: 'JSON',
		success: function (response) {
			if (response) {
				$('input#idVolunteer').val(id);
				$('input#edit_vName').val(response['name']);
				$('input#edit_vEmail').val(response['email']);
				$('input#edit_vUsername').val(response['username']);
				let selectGroup = document.getElementById('edit_vGroup');
				selectGroup[0] = new Option(response['group_name'], response['group_id'], true, true);
				$('div#kt_modal_edit_volunteer').modal('show');
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
});
/* end:: edit volunteer */
