if (typeof data != 'undefined') {
	let user_id = data['id'];
	/* begin:: delete volunteer */
	$('a#deleteVolunteer').click(function () {
		let id = $('input#idVolunteer').val();
		swal
			.fire({
				title: `Hapus Relawan?`,
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
								window.location.href = `${base_url}volunteers-management`;
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
	$('a#editVolunteer').click(function () {
		blockUI.block();
		$.ajax({
			url: `${base_url}volunteers-management/voluById`,
			method: 'POST',
			data: {
				id: user_id,
			},
			dataType: 'JSON',
			success: function (response) {
				$('input#edit_name').val(response['name']);
				$('input#edit_nik').val(response['nik']);
				$('input#edit_email').val(response['email']);
				$('input#edit_phone').val(response['phone']);
				$('textarea#edit_address').val(response['address']);
				$('input[name="edit_gender"][value="' + response['gender'] + '"]').prop('checked', true);
				$('input#edit_placeOfbirth').val(response['place_ofbirth']);
				$('input#edit_dateOfbirth').val(response['date_ofbirth']);
				if (response['status'] == 'active') {
					$('input#edit_status').prop('checked', true);
					$('span.status_lable').text('Aktif');
					$('span.status_lable').addClass('badge-light-success');
					$('span.status_lable').removeClass('badge-light-danger');
				} else {
					$('input#edit_status').prop('checked', false);
					$('span.status_lable').text('Nonaktif');
					$('span.status_lable').removeClass('badge-light-success');
					$('span.status_lable').addClass('badge-light-danger');
				}
				$('div#kt_profile_details_view').slideUp();
				$('div#edit_details').slideDown();
				blockUI.release();
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
		$('input#edit_dateOfbirth').flatpickr({
			defaultDate: data['date_ofbirth'],
		});
		$('input#edit_status').change(function () {
			if ($('input#edit_status').is(':checked')) {
				$('span.status_lable').text('Aktif');
				$('span.status_lable').addClass('badge-light-success');
				$('span.status_lable').removeClass('badge-light-danger');
			} else {
				$('span.status_lable').text('Nonaktif');
				$('span.status_lable').removeClass('badge-light-success');
				$('span.status_lable').addClass('badge-light-danger');
			}
		});
	});

	let form_edit = (function () {
		let form = $('form#form_edit')[0];
		let submitButton = $('button#submit_edit');
		let fv = FormValidation.formValidation(form, {
			fields: {
				edit_name: {
					validators: {
						notEmpty: {
							message: 'Masukan nama lengkap',
						},
					},
				},
				edit_phone: {
					validators: {
						notEmpty: {
							message: 'Masukan nomor telepon',
						},
					},
				},
				edit_address: {
					validators: {
						notEmpty: {
							message: 'Masukan nomor telepon',
						},
					},
				},
				edit_gender: {
					validators: {
						notEmpty: {
							message: 'Pilih jenis kelamin',
						},
					},
				},
				edit_placeOfbirth: {
					validators: {
						notEmpty: {
							message: 'Masukan tempat lahir',
						},
					},
				},
				edit_dateOfbirth: {
					validate: {
						notEmpty: {
							message: 'Masukan tanggal lahir',
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
						url: `${base_url}volunteers-management/edit`,
						type: 'POST',
						data: {
							id: user_id,
							name: $('input#edit_name').val(),
							phone: $('input#edit_phone').val(),
							address: $('textarea#edit_address').val(),
							gender: $("input[name='edit_gender']:checked").val(),
							place_ofbirth: $('input#edit_placeOfbirth').val(),
							date_ofbirth: $('input#edit_dateOfbirth').val(),
							status: $('input#edit_status').is(':checked') ? 'active' : 'nonactive',
						},
						dataType: 'JSON',
						success: function (response) {
							if (response.status === 'success') {
								setTimeout(function () {
									blockUI.release();
									toastr.success(response.message);
									window.location.reload();
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

		$('a#cancel_edit').click(function () {
			$('div#kt_profile_details_view').slideDown();
			$('div#edit_details').slideUp();
			$('form#form_edit')[0].reset();
			fv.resetForm();
		});
	})();
	/* end:: edit volunteer */
}
