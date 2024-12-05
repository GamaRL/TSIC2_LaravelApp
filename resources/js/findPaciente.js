let mensajes;

function createDataTable() {
    return $('#information').DataTable({
        responsive: true,
        columns: [
            {
                sClass: "text-center align-middle",
                data: 'id',
                render: (data) => {
                    return `<td><b>${data}</b></td>`
                }
            },
            {
                sClass: "text-center align-middle",

                data: 'nombre', render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                sClass: "text-center align-middle",
                data: 'apPat', render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                sClass: "text-center align-middle",
                data: 'apMat', render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                orderable: false,
                data: 'id',
                sClass: "text-center align-middle",

                render: (data) => {
                    return `
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-secondary" type="button"
                                   href="/pacientes/${data}/consulta">Consulta</a>


                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="options-${data}"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Más
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="options-${data}">
                                        <a class="dropdown-item" href="/pacientes/${data}">Ver
                                            Paciente</a>
                                        <a class="dropdown-item" href="#">Otras...</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        `;
                }
            }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            },
            buttons: {
                copy: "Copiar",
                colvis: "Visibilidad"
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: '/pacientes/dataTable',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function () {
                console.log("Error");
            }
        },
    });
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

function handleSelectChange() {
    const sesion = document.getElementById('sesion').value;
    const categorias = document.getElementById('categoria');
    categorias.innerHTML = "";
    for (const categoria of mensajes[sesion]) {
        let mensaje_option = document.createElement('option');
        mensaje_option.value = categoria;
        mensaje_option.innerText = categoria;
        categorias.append(mensaje_option);
    }
}

function fillFormMensajes() {
    for (const fecha in mensajes)
        if (mensajes.hasOwnProperty(fecha)) {
            let fecha_option = document.createElement('option');
            let fecha_ = new Date(fecha);
            fecha_option.value = fecha;
            fecha_option.innerText = `${fecha_.getUTCDate()}/${fecha_.getUTCMonth()}/${fecha_.getUTCFullYear()}`;
            document.getElementById('sesion')
                .append(fecha_option)
        }
    handleSelectChange()
}

function getMensajesData() {
    fetch('/pacientes/mensajes_data_all')
        .then(response => response.json())
        .then(data => {
            mensajes = data;
            fillFormMensajes(data);
            document.getElementById('sesion')
                .addEventListener('change', handleSelectChange)
            document.getElementById('mensajes-form')
                .addEventListener('submit', handleSubmit)
        })
}

if (document.readyState === 'loading')
    $(document).ready(function () {
        createDataTable()
    })
else
    createDataTable()

getMensajesData()

