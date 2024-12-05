function graphLine(context, data, options) {
    new Chart(context, {
        type: 'line',
        data: {
            labels: data.map((item, i) => `Sesión ${i + 1}`),
            datasets: options.vars.map((item) => {
                return {
                    label: item.label,
                    borderColor: item.color,
                    backgroundColor: item.color,
                    fill: false,
                    data: data.map(consulta => consulta[item.index]),
                }
            })
        },
        options: {
            responsive: true,
            hoverMode: 'index',
            aspectRatio: 1.5,
            scales: {
                yAxes: [{
                    ticks: {
                        max: 100,
                        min: 0,
                        stepSize: 10
                    }
                }]
            },
            title: {
                display: true,
                text: options.title
            },
        }
    })
}

function drawGraphics() {
    fetch('/admin/estadisticas/get/general')
        .then(response => response.json())
        .then(data => {
            let data_diab = data.map(sesion => {
                return {
                    'diabeticos': Math.round(10000 * sesion.diabeticos / sesion.asistentes) / 100,
                    'prediabeticos': Math.round(10000 * sesion.prediabeticos / sesion.asistentes) / 100,
                    'normales': Math.round(10000 * sesion.normales / sesion.asistentes) / 100,
                }
            });

            let data_alertas = data.map((sesion) => {
                let {alertas} = sesion;
                console.log(alertas);
                return {
                    glucosa: Math.round(10000 * alertas.glucosa / sesion.asistentes) / 100,
                    tension: Math.round(10000 * alertas.tension / sesion.asistentes) / 100,
                    icc: Math.round(10000 * alertas.icc / sesion.asistentes) / 100,
                    imc: Math.round(10000 * alertas.imc / sesion.asistentes) / 100,
                }
            });
            console.log(data_alertas);

            document.getElementById('graph-diabetes').classList.remove('d-none');
            document.getElementById('graph-alertas').classList.remove('d-none');
            document.getElementById('loading').classList.add('d-none');
            document.getElementById('loading').classList.remove('d-flex');

            graphLine(document.getElementById('diabeticos'), data_diab, {
                title: "Cantidad de diabéticos",
                vars: [{
                    color: "rgb(61,5,193)",
                    label: "Diabéticos(%)",
                    index: "diabeticos"
                }]
            });

            graphLine(document.getElementById('prediabeticos').getContext("2d"), data_diab, {
                title: "Prediabeticos",
                vars: [{
                    color: "rgb(143,194,2)",
                    label: "Prediabeticos (%)",
                    index: "prediabeticos"
                }]
            });

            graphLine(document.getElementById('normales').getContext("2d"), data_diab, {
                title: "Normales",
                vars: [{
                    color: "rgb(5,171,193)",
                    label: "Normales (%)",
                    index: "normales"
                }]
            });

            graphLine(document.getElementById('glucosa').getContext('2d'), data_alertas, {
                title: "Alertas de Glucosa",
                vars: [{
                    color: "#815294",
                    label: "(%)",
                    index: "glucosa"
                }]
            });

            graphLine(document.getElementById('tension').getContext('2d'), data_alertas, {
                title: "Alertas de Tensión Arterial",
                vars: [{
                    color: "#df3f3d",
                    label: "(%)",
                    index: "tension"
                }]
            });

            graphLine(document.getElementById('icc').getContext('2d'), data_alertas, {
                title: "Alertas de ICC",
                vars: [{
                    color: "#fa9240",
                    label: "(%)",
                    index: "icc"
                }]
            });
            graphLine(document.getElementById('imc').getContext('2d'), data_alertas, {
                title: "Alertas de IMC",
                vars: [{
                    color: "#f9c84b",
                    label: "(%)",
                    index: "imc"
                }]
            });
        })
}

document.addEventListener('DOMContentLoaded', () => {
    drawGraphics();
});
