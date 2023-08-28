if (typeof data != 'undefined') {
	let id = data['id'];
	/* begin:: edit profile */
	$('a#editProfile').click(function () {
		$.ajax({
			url: `${base_url}my_profile/getCurrentUserData`,
			type: 'POST',
			data: {
				id: id,
			},
			dataType: 'JSON',
			success: function (response) {
				$('input[name="idUser"]').val(response['id']);
				$('input[name="editName"]').val(response['name']);
				$('input[name="editEmail"]').val(response['email']);
				$('input[name="editNIP"]').val(response['nip']);
				$('input[name="editUsername"]').val(response['username']);
				$('input[name="editPhone"]').val(response['phone']);
				$('textarea[name="editAddress"]').val(response['address']);
				$('input[name="editGender"][value="' + response['gender'] + '"]').prop('checked', true);
				$('#editModal').modal('show');
			},
		});
	});

	let formEdit = (function () {
		let submitButton = $('#edit_button');
		let form = $('form#editForm')[0];
		let fv = FormValidation.formValidation(form, {
			fields: {
				editName: {
					validators: {
						notEmpty: {
							message: 'Masukan nama lengkap',
						},
					},
				},
				editNip: {
					validators: {
						notEmpty: {
							message: 'Masukan NIP',
						},
					},
				},
				editEmail: {
					validators: {
						notEmpty: {
							message: 'Masukan email',
						},
						emailAddress: {
							message: 'Alamat email tidak valid',
						},
					},
				},
				editPhone: {
					validators: {
						notEmpty: {
							message: 'Masukan no telepon',
						},
					},
				},
				editGender: {
					validators: {
						notEmpty: {
							message: 'Pilih jenis kelamin',
						},
					},
				},
				editAddress: {
					validators: {
						notEmpty: {
							message: 'Masukan alamat',
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

					var formData = new FormData();
					formData.append('gambar', $('#editAvatar')[0].files[0]);
					formData.append('name', $('input#editName').val());
					formData.append('phone', $('input#editPhone').val());
					formData.append('gender', $('input[name="editGender"]:checked').val());
					formData.append('address', $('textarea#editAddress').val());

					$.ajax({
						url: `${base_url}my_profile/editProfile`,
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						dataType: 'JSON',
						success: function (response) {
							if (response.status == 'success') {
								var base64Image = response.base64_image;
								console.log(base64Image);
								blockUI.release();
								Swal.fire({
									icon: 'success',
									title: response.message,
									confirmButtonText: 'Oke',
								}).then((result) => {
									if (result.isConfirmed) {
										window.location.reload();
									}
								});
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
			submitButton.attr('disabled', false);
		});

		$('input#editAvatar').on('change', function () {
			var file = $(this)[0].files[0];
			console.log(file);
		});
	})();

	/* $('form#editForm').submit(function () {
		let id = $('input[name="idUser"]').val(),
			name = $('input[name="editName"]').val(),
			email = $('input[name="editEmail"]').val(),
			phone = $('input[name="editPhone"]').val(),
			gender = (function () {
				if ($('input[name="editGender"][value="male"]').is(':checked')) {
					return 'male';
				} else if ($('input[name="editGender"][value="female"]').is(':checked')) {
					return 'female';
				}
			})(),
			address = $('textarea[name="editAddress"]').val();

		$.ajax({
			url: `${base_url}my_profile/editProfile`,
			type: 'POST',
			data: {
				id: id,
				name: name,
				email: email,
				phone: phone,
				gender: gender,
				address: address,
			},
			dataType: 'JSON',
			success: function (response) {
				if (response.status == 'success') {
					window.location.reload();
				}
			},
		});
	}); */
	/* end:: edit profile */
}
