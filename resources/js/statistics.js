let chartGlucosa;
let chartTASist;
let chartTADiast;
let chartDiabetes;

function drawGlucosa(data) {
	chartGlucosa = new Chart(document.getElementById('glucosa').getContext('2d'), {
		type: 'bar',
		data: {
			labels: data.map(item => item.tag),
			datasets: [{
				label: "Frecuencia",
				borderColor: 'rgb(73,68,231)',
				backgroundColor: 'rgb(73,68,231)',
				fill: false,
				data: data.map(item => item.size),
			}, ],
		},
		options: {
            responsiveAnimationDuration: 500,
            aspectRatio: 1.5,
			hoverMode: 'index',
			title: {
				display: true,
				text: `Histograma de de Glucosas (Sesión ${getSesion()})`
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
}

function drawTensionArterialSist(data) {
	chartTASist = new Chart(document.getElementById('ta_sist').getContext('2d'), {
		type: 'bar',
		data: {
			labels: data.map(item => item.tag),
			datasets: [{
				label: `Frecuencia`,
				borderColor: "rgb(168,19,222)",
				backgroundColor: "rgb(168,19,222)",
				fill: false,
				data: data.map(item => item.size),
			}, ],
		},
		options: {
            responsiveAnimationDuration: 500,
			hoverMode: 'index',
			aspectRatio: 1.5,
			title: {
				display: true,
				text: `Tensión Arterial Sistólica (Sesión ${getSesion()})`
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
}

function drawTensionArterialDiast(data) {
	chartTADiast = new Chart(document.getElementById('ta_diast').getContext('2d'), {
		type: 'bar',
		data: {
			labels: data.map(item => item.tag),
			datasets: [{
				label: `Frecuencia`,
				borderColor: "rgb(19,222,158)",
				backgroundColor: "rgb(19,222,158)",
				fill: false,
				data: data.map(item => item.size),
			}, ],
		},
		options: {
            responsiveAnimationDuration: 500,
			hoverMode: 'index',
			aspectRatio: 1.5,
			title: {
				display: true,
				text: `Tensión Arterial Diastólica (Sesión ${getSesion()})`
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
					},
				}]
			}
		}
	});
}

function drawDiabetes(data) {
	console.log(data);
	chartDiabetes = new Chart(document.getElementById('diabetes').getContext('2d'), {
		type: 'pie',
		data: {
			datasets: [{
				data: [data.diabeticos, data.prediabeticos, data.normales],
				backgroundColor: [
					'red',
					'orange',
					'blue'
				]
			}],
			labels: [
				'Diabeticos',
				'Prediabeticos',
				'Otros'
			]
		},
		options: {
            responsiveAnimationDuration: 500,
			hoverMode: 'index',
			aspectRatio: 1.5,
			title: {
				display: true,
				text: `Tensión Arterial Diastólica (Sesión ${getSesion()})`
			},
		}
	});
}

function getSesion() {
	return document.getElementById("sesion").value
}

function getData() {
	fetch(`/admin/estadisticas/get/${getSesion()}`)
		.then(response => {
			return response.json();
		})
		.then(data => {
			drawGlucosa(data.glucosa);
			drawTensionArterialSist(data.ta_sist);
			drawTensionArterialDiast(data.ta_diast);
			drawDiabetes(data.diabetes);
		})
}

document.addEventListener('DOMContentLoaded', () => {
	document.getElementById("search")
		.addEventListener("click", () => {
			if (chartGlucosa && chartTASist && chartTADiast) {
				chartTADiast.destroy();
				chartTASist.destroy();
				chartGlucosa.destroy();
				chartDiabetes.destroy();
			}
            document.getElementById('graph-container')
                .classList.remove('d-none');
			getData();
		})
});
