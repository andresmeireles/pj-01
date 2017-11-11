$(function () {

	var ctx = $('#yearProduction');

	var yearProduction = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Janeiro', 'Fevereiro', 'Março'],
			datasets: [{
				label: '# Production Amount',
				data: [1850, 1787, 2016],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
				],
				borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 2,
			}],
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
					},
				}],
			}
		},
	});
});