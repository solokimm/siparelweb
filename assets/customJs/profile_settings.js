/* begin:: change email */
$("button#editEmail").click(function () {
	$("div#kt-edit-email").slideToggle();
});

let changeEmail = (function () {
	let form = document.getElementById("changeEmail_form"),
		submitButton = document.getElementById("cahngeEmail_submit");
	let validator = FormValidation.formValidation(form, {
		fields: {
			newEmailAddress: {
				validators: {
					notEmpty: {
						message: "Masukan Alamat Email Baru",
					},
					emailAddress: {
						message: "Alamat Email Tidak Valid",
					},
				},
			},
			confirmPassword: {
				validators: {
					notEmpty: {
						message: "Masukan Kata Sandi Sebelumnya",
					},
				},
			},
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5(),
			submitButton: new FormValidation.plugins.SubmitButton(),
			icon: new FormValidation.plugins.Icon({
				valid: "fa fa-check",
				invalid: "fa fa-times",
				validating: "fa fa-refresh",
			}),
			fieldStatus: new FormValidation.plugins.FieldStatus({
				onStatusChanged: function (areFieldsValid) {
					areFieldsValid
						? submitButton.removeAttribute("disabled")
						: submitButton.setAttribute("disabled", "disabled");
				},
			}),
		},
	});

	submitButton.addEventListener("click", function () {
		blockUI.block();
		validator.validate().then(function (status) {
			if (status === "Valid") {
				let newEmail = $("input#newEmailAddress").val(),
					confirmPass = $("input#confirmPassword").val();

				$.ajax({
					url: `${base_url}profile-settings/changeEmail`,
					type: "POST",
					data: {
						email: newEmail,
						password: confirmPass,
					},
					dataType: "JSON",
					success: function (response) {
						if (response.status === "success") {
							setTimeout(function () {
								blockUI.release();
								validator.resetForm(true);
								toastr.success(response.message);
								$("span#currEmail").text(newEmail);
							}, 1500);
						}
						if (response.status === "invalid") {
							setTimeout(function () {
								blockUI.release();
								validator.updateFieldStatus("confirmPassword", "Invalid");
								toastr.warning(response.message);
							}, 1500);
						}
					},
				});
			} else {
				blockUI.release();
			}
		});
	});
})();
/* end:: change email */

/* begin:: change pass */
$("button#changePass").click(function () {
	$("div#kt-change-pass").slideToggle();
});

let changePassword = (function () {
	/* begin:: form validation */
	let form = document.getElementById("changePass_form"),
		submitButton = document.getElementById("changePass_submit");
	let validator = FormValidation.formValidation(form, {
		fields: {
			currPassword: {
				validators: {
					notEmpty: {
						message: "Masukan Kata Sandi Sebelumnya",
					},
				},
			},
			newPassword: {
				validators: {
					notEmpty: {
						message: "Masukan Kata Sandi Baru",
					},
					stringLength: {
						min: 8,
						message: "Minimal Panjang Kata Sandi Adalah 8 Karakter",
					},
				},
			},
			confirmNewPassword: {
				validators: {
					notEmpty: {
						message: "Konfirmasi Kata Sandi Baru",
					},
					identical: {
						compare: function () {
							return $('input[name="newPassword"]').val();
						},
						message: "Kata Sandi Tidak Sesuai",
					},
					stringLength: {
						min: 8,
						message: "Minimal Panjang Kata Sandi Adalah 8 Karakter",
					},
				},
			},
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5(),
			submitButton: new FormValidation.plugins.SubmitButton(),
			icon: new FormValidation.plugins.Icon({
				valid: "fa fa-check",
				invalid: "fa fa-times",
				validating: "fa fa-refresh",
			}),
			fieldStatus: new FormValidation.plugins.FieldStatus({
				onStatusChanged: function (areFieldsValid) {
					areFieldsValid
						? submitButton.removeAttribute("disabled")
						: submitButton.setAttribute("disabled", "disabled");
				},
			}),
		},
	});

	form
		.querySelector('[name="newPassword"]')
		.addEventListener("input", function () {
			validator.revalidateField("confirmNewPassword");
		});

	submitButton.addEventListener("click", function () {
		blockUI.block();
		validator.validate().then(function (status) {
			if (status === "Valid") {
				let currPassword = $("input#currPassword").val(),
					newPassword = $("input#newPassword").val();

				$.ajax({
					url: `${base_url}profile-settings/changePass`,
					method: "POST",
					data: {
						currPass: currPassword,
						newPass: newPassword,
					},
					dataType: "JSON",
					success: function (response) {
						if (response.status === "success") {
							setTimeout(function () {
								blockUI.release();
								validator.resetForm(true);
								toastr.success(response.message);
							}, 1500);
						}
						if (response.status === "invalid") {
							setTimeout(function () {
								blockUI.release();
								validator.updateFieldStatus("currPassword", "Invalid");
								toastr.warning(response.message);
							}, 1500);
						}
					},
				});
			} else {
				blockUI.release();
			}
		});
	});
	/* end:: form validation */
})();
/* end:: change pass */

/* begin:: change status */
let changeStatus = (function () {
	$("form#changeStatus_form").submit(function () {
		let checkBox = $("input#confirmCheckBox");
		if (checkBox.is(":checked")) {
			$(".checKMessage").addClass("d-none");
			Swal.fire({
				buttonsStyling: false,
				icon: "warning",
				text: "Here's a basic example of SweetAlert!",
				showDenyButton: true,
				confirmButtonText: "Nonaktifkan",
				denyButtonText: "Batalkan",
				customClass: {
					confirmButton: "btn btn-danger",
					denyButton: "btn btn-primary",
				},
			}).then((result) => {
				if (result.isConfirmed) {
					blockUI.block();
					$.ajax({
						url: `${base_url}profile-settings/changeStatus`,
						method: "POST",
						dataType: "JSON",
						success: function (response) {
							if (response.status === "success") {
								setTimeout(function () {
									blockUI.release();
									toastr.success(response.message);
								}, 1500);
							}
							if (response.status === "invalid") {
								setTimeout(function () {
									blockUI.release();
									toastr.warning(response.message);
								}, 1500);
							}
						},
					});
				}
			});
		} else {
			blockUI.release();
			toastr.warning("Tidak Dapat Melanjutan Proses");
			$(".checKMessage").removeClass("d-none");
		}
	});
})();
/* end:: change status */
