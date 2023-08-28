/* begin:: curr location */
function GetCurrLocation() {
	return new Promise((resolve, reject) => {
		if ('geolocation' in navigator) {
			navigator.geolocation.getCurrentPosition(
				function (position) {
					const latitude = position.coords.latitude;
					const longitude = position.coords.longitude;
					const data = [latitude, longitude];
					resolve(data);
				},
				function (error) {
					Swal.fire({
						icon: 'error',
						title: 'Izin Lokasi Ditolak!',
						text: 'Izinkan penggunaan lokasi pada peramban Anda.',
						confirmButtonText: 'Tutup',
					});
					reject(error);
				}
			);
		} else {
			const error = {
				code: 'NOT_SUPPORTED',
				message: 'Geolocation is not supported in this browser.',
			};
			reject(error);
		}
	});
}

let map;
let search;
let circle;
let markersArray = [];

GetCurrLocation()
	.then((data) => {
		$('input#latlng').val(`${data[0]}, ${data[1]}`);
		map = L.map('search_area_maps').setView([data[0], data[1]], 15);
		const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
		}).addTo(map);
		let currentMarker = L.marker([data[0], data[1]]).addTo(map).bindPopup(`<em>Lokasi saat ini</em>`);
		search = L.Control.geocoder()
			.addTo(map)
			.on('markgeocode', function (event) {
				let location = event.geocode.center;
				if (circle) {
					circle.remove();
				}
				for (let i = 0; i < markersArray.length; i++) {
					map.removeLayer(markersArray[i]);
				}
				currentMarker.remove();
				$('input#latlng').val(`${location.lat}, ${location.lng}`);
			});
	})
	.catch((error) => {
		console.error('Error:', error);
	});

$('form#kt_search_area_form').submit(function () {
	let radiusValue = $('input#radius').val(),
		loc = $('input#latlng').val(),
		latlang = loc.split(', ');
	blockUI.block();
	if (radiusValue > 999) {
		$('#detailCard').slideDown();
		$.ajax({
			url: `${base_url}search-area/getNewsData`,
			type: 'POST',
			dataType: 'JSON',
			success: function (response) {
				if (circle) {
					map.removeLayer(circle);
				}
				map.setView([latlang[0], latlang[1]], 15);
				circle = L.circle([latlang[0], latlang[1]], { radius: radiusValue }).addTo(map);
				for (let i = 0; i < markersArray.length; i++) {
					map.removeLayer(markersArray[i]);
				}
				markersArray = [];
				$.each(response, function (key, value) {
					let ll = L.latLng(value['location_lat'], value['location_lng']);
					let distance = ll.distanceTo(latlang);
					if (distance <= radiusValue) {
						let marker = L.marker(ll).addTo(map).bindPopup(`<b>${value['title']}</b>`);
						marker.on('click', function () {
							$('html, body').animate({ scrollTop: $('#detailCard').offset().top }, 800);
							let parseImage = JSON.parse(value['image']);
							let item1 = ``;
							let item2 = ``;
							$.each(parseImage, function (key, value) {
								item1 += `<li data-bs-target="#kt_carousel_3_carousel" data-bs-slide-to="${key}" class="ms-1 ${key === 0 ? 'active' : ''}"></li>`;
								item2 += `
                <div class="carousel-item ${key === 0 ? 'active' : ''}">
                    <a class="d-block overlay h-100" data-fancybox="gallery" data-src="data:image/jpg;base64,${value}">
                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px h-100" style="background-image:url(data:image/jpg;base64,${value})"></div>
                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                        </div>
                    </a>
                </div>
                `;
							});
							let html = `
              <div class="col-sm-6 mb-10 mb-sm-0">
                  <div id="kt_carousel_3_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="8000">
                      <div class="d-flex align-items-center justify-content-center flex-wrap">
                          <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                              ${item1}
                          </ol>
                      </div>
                      <div class="carousel-inner pt-8">
                          ${item2}
                      </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="d-flex flex-column h-100">
                      <div class="mb-7">
                          <div class="mb-6">
                              <span class="text-gray-400 fs-3 fw-bold me-2 d-block lh-1 pb-1">${value['location_lat']}, ${value['location_lng']}</span>
                          </div>
                          <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                              <div class="d-flex align-items-center me-5 me-xl-13">
                                  <div class="symbol symbol-100px symbol-circle me-3"> <img src="${value['volu_picture'] != null ? value['volu_picture'] : base_url + 'assets/media/avatars/blank.png'}" class="" alt=""> </div>
                                  <div class="m-0"> <span class="fw-bold text-gray-800 text-hover-primary fs-3 info_VolunteerName">${value['volu_name']}</span> <span class="fw-semibold text-gray-400 d-block fs-4 info_UploadedTime">${value['upload_timestamp']}</span> </div>
                              </div>
                          </div>
                      </div>
                      <div class="d-flex flex-column border border-1 border-gray-300 p-6 mb-8 card-rounded">
                          <span class="fw-bold text-gray-800 fs-1 lh-1 pb-1 info_Title">${value['title']}</span>
                          <span class="fw-semibold text-gray-600 fs-3 pb-1 info_Content">${value['content']}</span>
                      </div>
                  </div>
              </div>
              `;
							$('div#detailReport').html(html);
							/* $('.info_Latlng').text(`${value['location_lat']}, ${value['location_lng']}`);
							$('.info_Title').text();
							$('.info_VolunteerName').text();
							$('.info_UploadedTime').text();
							$('.info_Content').text(); */
						});
						markersArray.push(marker);
					}
				});
				setTimeout(function () {
					blockUI.release();
				}, 2000);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$('#startSearch').attr('data-kt-indicator', 'off');
				$('#startSearch').prop('disabled', false);
				swal.fire({
					type: 'error',
					title: 'Error',
					html: jqXHR.responseText,
				});
			},
		});
	} else {
		toastr.warning('Minimal radius pencarian adalah 1000m (1 Kilometer)');
		blockUI.release();
	}
});
/* end:: curr location */

Fancybox.bind('[data-fancybox="gallery"]', {});
