/* begin:: Groups Table */
var table = $("table#table_groups").DataTable({
	paging: true,
	responsive: true,
	searchDelay: 500,
	processing: true,
	serverSide: true,
	pageLength: 5,
	lengthMenu: [
		[5, 10, 25, 50, 100, -1],
		[5, 10, 25, 50, 100, "All"],
	],
	language: {
		emptyTable: "Tidak ada data tersedia",
		info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
		infoEmpty: "Menampilkan 0 - 0 dari 0 data",
	},
	ajax: {
		url: `${base_url}groups-management/table`,
		dataType: "JSON",
	},
	order: [[0, "asc"]],
	columns: [
		{ data: "name" },
		{
			data: "members",
			class: "text-center",
		},
		{
			data: "id",
			class: "text-center",
			orderable: false,
			render: function (data, type, row) {
				return `
					<a href="javascript:void(0);" id="editGroup" data-id="${data}" class="btn btn-sm btn-primary btn-clean btn-icon btn-icon-md">
						<i class="fa fa-edit"></i>
					</a>
					<a href="javascript:void(0);" id="deleteGroup" data-id="${data}" data-name="${row.name}" class="btn btn-sm btn-primary btn-clean btn-icon btn-icon-md" data-nik="">
						<i class="fa fa-trash"></i>
					</a>
				`;
			},
		},
	],
});

$("input#search-input").on("keyup", function () {
	table.search(this.value).draw();
});
/* end:: Groups Table */

/* begin:: Add Group */
$("a#cancelAdd").click(function () {
	$("div#kt_modal_add_group").modal("hide");
	$("form#addGroup")[0].reset();
});

$("form#addGroup").submit(function () {
	let groupName = $('input[name="groupName"]').val();

	$.ajax({
		url: `${base_url}groups-management/add`,
		type: "POST",
		data: { groupName: groupName },
		dataType: "JSON",
		success: function (response) {
			if (response.status == "success") {
				$("form#addGroup")[0].reset();
				$("div#kt_modal_add_group").modal("hide");
				toastr.success(response.message);
				table.ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			swal.fire({
				type: "error",
				title: "Error",
				html: jqXHR.responseText,
			});
		},
	});
});
/* end:: Add Group */

/* begin:: Edit Group */
$(document).on("click", "a#editGroup", function () {
	let id = $(this).data("id");
	$.ajax({
		url: `${base_url}groups-management/groupById`,
		type: "POST",
		data: { id: id },
		dataType: "JSON",
		success: function (response) {
			if (response.status == "success") {
				let name = response.data[0].name;
				$('input[name="idGroup"]').val(id);
				$("input[name='edit_groupName']").val(name);
				$("div#kt_modal_edit_group").modal("show");
			} else {
				toastr.error(response.status);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			swal.fire({
				type: "error",
				title: "Error",
				html: jqXHR.responseText,
			});
		},
	});
});

$("a#cancelEdit").click(function () {
	$("div#kt_modal_edit_group").modal("hide");
});

$("form#editGroup").submit(function () {
	let id = $('input[name="idGroup"]').val(),
		groupName = $('input[name="edit_groupName"]').val();

	$.ajax({
		url: `${base_url}groups-management/edit`,
		type: "POST",
		data: {
			id: id,
			groupName: groupName,
		},
		dataType: "JSON",
		success: function (response) {
			if (response.status == "success") {
				$("div#kt_modal_edit_group").modal("hide");
				toastr.success(response.message);
				table.ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			swal.fire({
				type: "error",
				title: "Error",
				html: jqXHR.responseText,
			});
		},
	});
});
/* end:: Edit Group */

/* begin:: Delete Group */
$(document).on("click", "a#deleteGroup", function () {
	let id = $(this).data("id"),
		name = $(this).data("name");
	swal
		.fire({
			title: `Hapus Group <b>${name}</b> ?`,
			showCancelButton: true,
			confirmButtonText: "Hapus",
			cancelButtonText: `Batal`,
			confirmButtonColor: "red",
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `${base_url}groups-management/delete`,
					type: "POST",
					data: {
						id: id,
					},
					dataType: "JSON",
					success: function (response) {
						if (response.status == "success") {
							toastr.success(response.message);
							table.ajax.reload();
						} else {
							swal.fire({
								icon: "error",
								text: response.message,
							});
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						swal.fire({
							type: "error",
							title: "Error",
							html: jqXHR.responseText,
						});
					},
				});
			}
		});
});
/* end:: Delete Group */
