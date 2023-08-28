function mapsChart() {
	am5.ready(function () {
		var root = am5.Root.new("volunteer_maps");
		root.setThemes([am5themes_Animated.new(root)]);
		var chart = root.container.children.push(
			am5map.MapChart.new(root, {
				panX: "rotateX",
				panY: "translateY",
				projection: am5map.geoNaturalEarth1(),
			})
		);
		chart.chartContainer.get("background").events.on("click", function () {
			chart.goHome();
		});
		chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
		var polygonSeries = chart.series.push(
			am5map.MapPolygonSeries.new(root, {
				geoJSON: am5geodata_indonesiaLow,
				exclude: ["AQ"],
			})
		);
		polygonSeries.mapPolygons.template.setAll({
			tooltipText: "{name}",
			templateField: "polygonSettings",
		});
		polygonSeries.data.setAll([
			{
				id: "ID-JK",
				polygonSettings: {
					fill: am5.color(0xff3c38),
				},
			},
		]);
		/* polygonSeries.mapPolygons.template.setAll({
			tooltipText: "{id} {name}",
			toggleKey: "active",
			interactive: true,
		});
		polygonSeries.mapPolygons.template.states.create("hover", {
			fill: root.interfaceColors.get("primaryButtonHover"),
		});
		polygonSeries.mapPolygons.template.states.create("active", {
			fill: root.interfaceColors.get("primaryButtonActive"),
		}); */
		chart.appear(1000, 100);
	});
}
mapsChart();

function countData() {
	var countVolunteers = document.querySelector(".countVolu");
	var countReports = document.querySelector(".countReports");

	$.ajax({
		url: `${base_url}dashboard/countData`,
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			anime({
				targets: countVolunteers,
				innerHTML: [50, response.volunteers],
				easing: "linear",
				round: 1,
			});

			anime({
				targets: countReports,
				innerHTML: [50, response.reports],
				easing: "linear",
				round: 1,
			});
		},
	});
}
countData();

function leaderBoard() {
	$.ajax({
		url: `${base_url}dashboard/leaderBoard`,
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			let leaderBoard = ``;
			$.each(response, function (key, value) {
				leaderBoard += `
				<div class="d-flex align-items-center mb-7">
					<div class="symbol symbol-50px me-5">
						<img src="${base_url}assets/media/avatars/300-6.jpg" class="" alt="" />
					</div>
					<div class="flex-grow-1">
						<a href="#" class="text-dark fw-bold text-hover-primary fs-6">${value["volunteer_name"]}</a>
						<span class="text-muted d-block fw-bold">Total laporan: ${value["total_news"]}</span>
					</div>
				</div>
				`;
			});
			$(".leaderBoard").html(leaderBoard);
		},
	});
}
leaderBoard();
