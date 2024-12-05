function makeDataTable() {
    let data = $('#information').DataTable({
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
                data: 'nombre',
                render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                sClass: "text-center align-middle",
                data: 'apPat',
                render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                sClass: "text-center align-middle",
                data: 'apMat',
                render: (data) => {
                    return `<td>${data}</td>`
                }
            },
            {
                sClass: "text-center align-middle",
                data: 'alertas',
                render: (data) => {
                    let alertas = "";
                    if (data.glucosa) alertas += '🟣';
                    if (data.imc) alertas += '🟡';
                    if (data.tension) alertas += '🔴';
                    if (data.icc) alertas += '🔶';

                    return alertas;
                }
            },
            {
                orderable: false,
                sClass: "text-center align-middle",
                data: 'id',
                render: (data) => {
                    return `
                        <div class="btn-group" role="group" aria-label="Información">
                            <a href="/admin/pacientes/${$('#sesion').val()}/${data}"
                                class="btn btn-secondary">Ver más</a>
                        </div>`
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
            url: `/pacientes/riesgo/dataTable/${$('#sesion').val()}`,
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

if (document.readyState === 'loading') {
    $(document).ready(function () {
        makeDataTable();
    });
} else {
    makeDataTable();
}

