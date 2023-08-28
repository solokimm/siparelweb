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
		url: `${base_url}news-report/table`,
		dataType: 'JSON',
	},
	order: [[0, 'asc']],
	columns: [
		{ data: 'upload_timestamp' },
		{ data: 'title' },
		{ data: 'volu_name' },
		{
			data: 'news_status',
			render: function (data, type, row) {
				if (data == 'published') {
					return `<span class="badge py-3 px-4 fs-7 badge-light-success">Terpublikasi</span>`;
				} else if (data == 'waiting') {
					return `<span class="badge py-3 px-4 fs-7 badge-light-primary">Belum dipublikasi</span>`;
				}
			},
		},
		{
			data: null,
			orderable: false,
			className: 'text-center',
			render: function (data, type, row) {
				return `
					<a href="${base_url}news-report/details/${data.id}" style="background-color: #F45905;" class="btn btn-active-warning btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
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

/* {
			data: 'image',
			render: function (data, type, row) {
				// if (data == 'published') {
				// 	return `<span class="badge py-3 px-4 fs-7 badge-light-success">Terpublikasi</span>`;
				// } else if (data == 'waiting') {
				// 	return `<span class="badge py-3 px-4 fs-7 badge-light-primary">Belum dipublikasi</span>`;
				// }
				// console.log(data);
				let image = JSON.parse(data);
				console.log(image);
				return `<img src="${image[0]}"></img>`;
			},
		}, */
