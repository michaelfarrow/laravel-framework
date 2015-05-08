require(['config'], function (config) {

	require([
		'jquery',
		'fastclick',
		'chart'
	], function (
		$,
		FastClick,
		Chart
	) {

		FastClick.attach(document.body);

		Chart.defaults.global.responsive = true;

		$('.stats-chart').each(function()
		{
			var id = $(this).attr('id'),
					chartInfo = window[id],
					ctx = $(this).get(0).getContext("2d");

					console.log(chartInfo.data, ctx);

			switch (chartInfo.type)
			{
					case 'doughnut':
							new Chart(ctx).Doughnut(chartInfo.data);
							break;
					case 'pie':
							new Chart(ctx).Pie(chartInfo.data);
							break;
					case 'line':
							new Chart(ctx).Line(chartInfo.data);
							break;
			}
		});

// 		var data = {
//     labels: ["January", "February", "March", "April", "May", "June", "July"],
//     datasets: [
//         {
//             label: "My First dataset",
//             fillColor: "rgba(220,220,220,0.2)",
//             strokeColor: "rgba(220,220,220,1)",
//             pointColor: "rgba(220,220,220,1)",
//             pointStrokeColor: "#fff",
//             pointHighlightFill: "#fff",
//             pointHighlightStroke: "rgba(220,220,220,1)",
//             data: [65, 59, 80, 81, 56, 55, 40]
//         },
//         {
//             label: "My Second dataset",
//             fillColor: "rgba(151,187,205,0.2)",
//             strokeColor: "rgba(151,187,205,1)",
//             pointColor: "rgba(151,187,205,1)",
//             pointStrokeColor: "#fff",
//             pointHighlightFill: "#fff",
//             pointHighlightStroke: "rgba(151,187,205,1)",
//             data: [28, 48, 40, 19, 86, 27, 90]
//         }
//     ]
// };

// 		var ctx = $("#myChart").get(0).getContext("2d");
// 		var myLineChart = new Chart(ctx).Line(data, {
// 			responsive: true
// 		});

	});

});