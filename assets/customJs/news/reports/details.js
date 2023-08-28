function showLocation() {
	let map = L.map('kt_contact_map').setView([data['location_lat'], data['location_lng']], 16);

	let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
	}).addTo(map);

	let marker = L.marker([data['location_lat'], data['location_lng']]).addTo(map).bindPopup(data['location_name']).openPopup();
}

function edit_report(id) {
	let submitButton = $('#submit_edit');
	let form = $('form#form_edit')[0];
	let fv = FormValidation.formValidation(form, {
		fields: {
			edit_reportTitle: {
				validators: {
					notEmpty: {
						message: 'Masukan judul laporan',
					},
				},
			},
			edit_reportContent: {
				validators: {
					notEmpty: {
						message: 'Masukan detail laporan',
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
					url: `${base_url}news-report/reportAction/edit`,
					type: 'POST',
					data: {
						id: id,
						title: $('input[name="edit_reportTitle"]').val(),
						content: $('textarea[name="edit_reportContent"]').val(),
					},
					dataType: 'JSON',
					success: function (response) {
						if (response.status == 'success') {
							blockUI.release();
							Swal.fire({
								html: `<strong class='fs-3'>${response.message}</strong>`,
								icon: 'success',
								confirmButtonText: 'Oke',
								customClass: {
									confirmButton: 'btn btn-success',
								},
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.reload();
								}
							});
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
			} else {
				toastr.warning('Terdapat inputan yang belum valid!');
			}
		});
	});
}

if (typeof data !== 'undefined') {
	let id = data['id'];
	Fancybox.bind('[data-fancybox="gallery"]', {});

	/* begin:: publish */
	$('button#publishButton').click(function () {
		Swal.fire({
			html: `<strong class='fs-3'>Publikasikan Laporan?</strong>`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: 'Lanjutkan',
			cancelButtonText: 'Batalkan',
			customClass: {
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-danger',
			},
		}).then((result) => {
			if (result.isConfirmed) {
				blockUI.block();
				$.ajax({
					url: `${base_url}news-report/reportAction/publish`,
					method: 'POST',
					dataType: 'JSON',
					data: {
						id: id,
					},
					success: function (response) {
						if (response.status == 'success') {
							blockUI.release();
							Swal.fire({
								html: `<strong class='fs-3'>Dipublikasikan!</strong>`,
								icon: 'success',
								confirmButtonText: 'Oke',
								customClass: {
									confirmButton: 'btn btn-success',
								},
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.reload();
								}
							});
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
	/* end:: publish */

	/* begin:: delete */
	$('a#deleteReport').click(function () {
		swal
			.fire({
				title: `<b>Hapus laporan?</b>`,
				showCancelButton: true,
				confirmButtonText: 'Hapus',
				cancelButtonText: `Batalkan`,
				confirmButtonColor: 'red',
			})
			.then((result) => {
				if (result.isConfirmed) {
					blockUI.block();
					$.ajax({
						url: `${base_url}news-report/reportAction/delete`,
						type: 'POST',
						data: {
							id: id,
						},
						dataType: 'JSON',
						success: function (response) {
							if (response.status == 'success') {
								blockUI.release();
								Swal.fire({
									html: `<strong class='fs-3'>${response.message}</strong>`,
									icon: 'success',
									confirmButtonText: 'Oke',
									customClass: {
										confirmButton: 'btn btn-success',
									},
								}).then((result) => {
									if (result.isConfirmed) {
										window.location.href = `${base_url}news-report`;
									}
								});
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
	/* end:: delete */

	/* begin:: edit */
	$('a#editReport').click(function () {
		blockUI.block();
		setTimeout(function () {
			$('div#data_report').slideUp();
			$('div#edit_report').slideDown();
			edit_report(id);
			blockUI.release();
		}, 2000);
	});
	$('button#cancel_edit').click(function () {
		$('div#data_report').slideDown();
		$('div#edit_report').slideUp();
	});
	/* end:: edit */
	showLocation();
}
