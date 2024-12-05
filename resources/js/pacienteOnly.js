let alertas, mensajes;

function graphLine(context, data, options) {
    let chart = new Chart(context, {
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
            aspectRatio: 1,
            title: {
                display: true,
                text: options.title
            },
        }
    })
}

function graphIntervalLine(context, data, config) {
    let gradiente = context.createLinearGradient(0, 0, 0, 300);
    gradiente.addColorStop(0, "rgb(0,200,16)");
    gradiente.addColorStop(0.3, "rgba(0,200,16,0.9)");
    gradiente.addColorStop(1, "rgba(255,255,255,1)");

    let chartGlucosa = new Chart(context, {
        type: 'line',
        data: {
            labels: data.map((medida, i) => `Sesión ${i + 1}`),
            datasets: [
                {
                    label: config.nombre,
                    borderColor: config.color,
                    backgroundColor: config.color,
                    fill: false,
                    data: data.map(consulta => consulta.medida),
                },
                {
                    label: "Max",
                    borderWidth: 0.5,
                    lineTension: 0,
                    borderColor: "rgb(0, 200, 16)",
                    backgroundColor: "rgba(0,200,16,0.3)",
                    fill: false,
                    data: data.map(medida => medida.intervalo[1]),
                },
                {
                    label: "Min",
                    borderWidth: 0.5,
                    lineTension: 0,
                    borderColor: "rgb(0, 200, 16)",
                    backgroundColor: "rgba(0,200,16,0.3)",
                    fill: '-1',
                    data: data.map(medida => medida.intervalo[0]),
                },
            ],
        },
        options: {
            responsive: true,
            hoverMode: 'index',
            aspectRatio: 1,
            title: {
                display: true,
                text: config.nombre
            },
        }
    });
}

function drawAllGraphs({data}) {
    graphIntervalLine(document.getElementById('glucosa').getContext("2d"), data.map((consulta) => {
        return {
            medida: consulta.cant_glucosa,
            intervalo: consulta.intervalo_glucosa
        }
    }), {color: "rgb(247, 153, 16)", nombre: "Glucosa"});
    graphIntervalLine(document.getElementById('ta_sist').getContext("2d"), data.map((consulta) => {
        return {
            medida: consulta.ta_sist,
            intervalo: consulta.intervalo_ta_sist
        }
    }), {color: "rgb(18,119,227)", nombre: "Tensión Arterial Sistólica"});

    graphIntervalLine(document.getElementById('ta_diast').getContext("2d"), data.map((consulta) => {
        return {
            medida: consulta.ta_diast,
            intervalo: consulta.intervalo_ta_diast
        }
    }), {color: "rgb(247,16,135)", nombre: "Tensión Arterial Diastólica"});

    graphIntervalLine(document.getElementById('imc').getContext("2d"), data.map((consulta) => {
        return {
            medida: (consulta.imc !== null) ? Math.round(consulta.imc * 100) / 100 : undefined,
            intervalo: consulta.intervalo_imc
        }
    }), {color: "rgb(103,27,245)", nombre: "IMC"});

    graphIntervalLine(document.getElementById('icc').getContext("2d"), data.map((consulta) => {
        return {
            medida: (consulta.icc !== null) ? Math.round(consulta.icc * 100) / 100 : undefined,
            intervalo: consulta.intervalo_icc
        }
    }), {color: "rgb(245,78,27)", nombre: "ICC"});

    graphLine(document.getElementById('medidas').getContext("2d"), data, {
        title: "Medidas",
        vars: [
            {color: 'rgb(25, 201, 64)', label: "Muslo(cm)", index: "muslo"},
            {color: 'rgb(29, 200, 187)', label: "Cuello(cm)", index: "cuello"},
            {color: 'rgb(0, 127, 195)', label: "Cintura(cm)", index: "cintura"},
            {color: 'rgb(247, 210, 0)', label: "Cadera(cm)", index: "cadera"},
        ]
    });

    graphLine(document.getElementById('pesos').getContext("2d"), data, {
        title: "Peso",
        vars: [{color: "rgb(75, 91, 106)", label: "Peso(Kg)", index: "peso"}]
    });

    graphLine(document.getElementById('oximetria').getContext("2d"), data, {
        title: "Oximetría",
        vars: [{color: "rgb(17,193,5)", label: "SpO2(%)", index: "oximetria"}]
    });

    function byteCount(s) {
        return encodeURI(s).split(/%..|./).length - 1;
    }

    setTimeout(() => {
        document.querySelector('input[name="peso"]').value = document.getElementById('pesos').toDataURL();
        document.querySelector('input[name="medidas"]').value = document.getElementById('medidas').toDataURL();
        document.querySelector('input[name="glucosa"]').value = document.getElementById('glucosa').toDataURL();
        document.querySelector('input[name="ta_diast"]').value = document.getElementById('ta_diast').toDataURL();
        document.querySelector('input[name="ta_sist"]').value = document.getElementById('ta_sist').toDataURL();
        document.querySelector('input[name="imc"]').value = document.getElementById('imc').toDataURL();
        document.querySelector('input[name="icc"]').value = document.getElementById('icc').toDataURL();
        document.querySelector('input[name="oximetria"]').value = document.getElementById('oximetria').toDataURL();
        document.getElementById('generar_reporte').classList.toggle('disabled')
    }, 1000)
}

function getURL_Stat() {
    return '/pacientes/' + document.getElementById('paciente_id').value + '/getStatistics';
}

function getURL_Mensajes() {
    return '/pacientes/' + document.getElementById('paciente_id').value + '/mensajes_data'
}

function handleOnChangeSesion() {
    let sesion = document.getElementById('sesion').value;

    let mensajes_disponibles = alertas[sesion].filter(alerta => !mensajes[sesion].hasOwnProperty(alerta));
    document.getElementById('categoria').innerHTML = "";

    if (alertas[sesion].length === 0) {
        let opt_cat = document.createElement('option');
        opt_cat.innerText = 'sano';
        opt_cat.value = 'sanos';
        document.getElementById('categoria').appendChild(opt_cat);
    }

    for (const disponible of mensajes_disponibles) {
        let opt_cat = document.createElement('option');
        opt_cat.innerText = `${disponible}`;
        opt_cat.value = disponible;
        document.getElementById('categoria').appendChild(opt_cat);
    }
}

function fillSesiones() {
    console.log(mensajes)
    for (const sesion in alertas) {
        if (alertas.hasOwnProperty(sesion)) {
            let mensajes_length = Array.isArray(mensajes[sesion]) ? mensajes[sesion].length : Object.keys(mensajes[sesion]).length;
            let alertas_length = Array.isArray(alertas[sesion]) ? alertas[sesion].length : Object.keys(alertas[sesion]).length;
            console.log(alertas_length, mensajes_length)
            if (mensajes_length < alertas_length || alertas_length === 0) {
                let opt_sesion = document.createElement('option');
                opt_sesion.innerText = `Sesión ${sesion}`;
                opt_sesion.value = sesion.toString();
                if (mensajes_length < alertas_length || (alertas_length === 0 && mensajes_length === 0))
                    document.getElementById('sesion').appendChild(opt_sesion);
            }
        }
    }
    try {
        handleOnChangeSesion();
    } catch (e) {
        console.log("No hay mensajes disponibles");
        document.getElementById('mensaje-modal-button').disabled = true;
        document.getElementById('mensaje-modal-button').classList.add('disabled');
    }
}

function handleErrors(errors) {
    for (const errorsKey in errors) {
        if (errors.hasOwnProperty(errorsKey)) {
            document.querySelector(`#${errorsKey} + .invalid-feedback`).innerText = errors[errorsKey]
            document.querySelector(`#${errorsKey}`)
                .classList.toggle('is-invalid');
        }
    }
}

function handleSubmit(e) {
    e.preventDefault();
    let form = document.getElementById('mensajes-form');
    document.querySelector('#send-message + button').classList.toggle('d-none');
    document.querySelector('#send-message').classList.toggle('d-none');
    fetch(form.action, {
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: new FormData(form)
    })
        .then(response => response.json())
        .then(data => {
            document.querySelector('#send-message + button').classList.toggle('d-none');
            document.querySelector('#send-message').classList.toggle('d-none');

            if (data.errors) {
                handleErrors(data.errors)
            } else {
                document.querySelector('#mensajes-form + div.alert').classList.toggle('d-none');
                form.reset();
                location.reload();
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    fetch(getURL_Stat())
        .then(response => response.json())
        .then(drawAllGraphs);
    fetch(getURL_Mensajes())
        .then(response => response.json())
        .then(data => {
            mensajes = data.mensajes;
            alertas = data.alertas;
            console.log(alertas);
            fillSesiones();
            document.getElementById('sesion').addEventListener('change', handleOnChangeSesion);
            document.getElementById('mensajes-form').addEventListener('submit', handleSubmit)
        })
})
