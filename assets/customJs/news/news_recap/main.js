/* begin:: Groups Table */
var table = $('table#table_news').DataTable({
	paging: true,
	responsive: true,
	searchDelay: 500,
	processing: true,
	serverSide: true,
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
		url: `${base_url}news-recap/table`,
		dataType: 'JSON',
	},
	order: [[0, 'asc']],
	columns: [
		{ data: 'volu_name' },
		{
			data: 'title',
			render: function (data, type, row) {
				return `
					<ul>
						<li>
						<b>Judul &nbsp;&nbsp;:</b> ${row['title']} <br>
						</li>
						<li>
						<b>Lokasi &nbsp;&nbsp;:</b> ${row['location_name']} <br>
						</li>
						<li>
						<b>Tanggal &nbsp;&nbsp;:</b> ${moment(row['upload_timestamp']).format('DD/MM/YYYY')} <br>
						</li>
					</ul>
				`;
			},
		},
		{ data: 'group_name' },
		{
			data: 'participants',
			class: 'text-center',
		},
		{
			data: 'id',
			render: function (data, type, row) {
				return `
					<a href="${base_url}news-report/details/${data}" target="_blank" style="background-color: #F45905;" class="btn btn-active-warning btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
						<i class="fa-solid fa-magnifying-glass text-white"></i>
						<b class="text-white fs-3">Lihat detail</b>
					</a>
				`;
			},
		},
	],
});

$('input#search-input').on('keyup', function () {
	table.search(this.value).draw();
});
/* end:: Groups Table */
