<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Paciente</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            width: 100%;
            margin-bottom: 2em;
        }

        header img {
            height: 130px;
            position: absolute;
            top: 20px;
            left: 0;
        }

        h3.titulo {
            font-weight: normal;
            width: 70%;
            text-align: center;
            margin: auto;
        }

        h4.subtitle {
            width: 100%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
        }

        table tr td, table tr th {
            border: 1px solid gray;
            font-size: 10pt;
            box-sizing: border-box;
            padding: 0.3em;
        }

        table.graficas tr td {
            border: none;
            text-align: center;
        }

        td.nombre {
            width: 60%;
        }

        td.edad, td.sexo {
            width: 20%;
        }

        span.page-break {
            page-break-after: always;
        }

        div.info-section {
            width: 100%;
        }

        div.info-section table {
            width: 100%;
        }

        div.info-section table td.spacing {
            width: 60%;
            border: none;
        }

        table.diagnostico td, table.diagnostico th {
            border: none;
            text-align: center;
            width: 20%;
        }

        table.resumen td, table.resumen th {
            text-align: center;
            font-size: 8pt;
        }
    </style>
</head>
<body>
<header>
    <img src="{{url("/logo.png")}}" alt="">
    <h3 class="titulo">SERVICIOS MÉDICOS INTEGRALES DIVINO NIÑO, A.C.</h3>
    <h3 class="titulo">RENOVANDO TU SALUD</h3>
</header>
<h4 class="subtitle">DATOS PERSONALES</h4>
<div class="info-section">
    <table>
        <tr>
            <td rowspan="2" class="spacing"></td>
            <td><b>Fecha: </b> <span style="font-family:'Lucida Console', monospace">{{$fecha}}</span></td>
        </tr>
        <tr>
            <td><b>No. Beneficiario: </b> <span
                    style="font-family:'Lucida Console', monospace">{{$paciente->id}}</span></td>
        </tr>
    </table>
</div>
<table>
    <tr>
        <td class="nombre"><b>Nombre:</b> <span
                style="text-transform: uppercase; font-family:'Lucida Console', monospace">{{$paciente->nombre}} {{$paciente->apPat}} {{$paciente->apMat}}</span>
        </td>
        <td class="edad"><b>Edad:</b> <span style="font-family:'Lucida Console', monospace">{{(new DateTime())->diff(new DateTime($paciente->fecha_nacimiento))->y}} años </span>
        </td>
        <td class="sexo"><b>Sexo:</b> <span
                style="font-family:'Lucida Console', monospace">{{$paciente->sexo === "M" ? "Hombre" : "Mujer"}}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="curp"><b>CURP:</b> <span
                style="font-family:'Lucida Console', monospace">{{$paciente->curp}}</span></td>
    </tr>
    <tr>
        <td colspan="2"><b>Colonia: </b> <span
                style="text-transform: uppercase; font-family:'Lucida Console', monospace">{{$paciente->asentamiento->nombre}}</span>
        </td>
        <td><b>C.P.</b> <span style="font-family:'Lucida Console', monospace">{{$paciente->asentamiento->cp}}</span>
        </td>
    </tr>
</table>

<h4 class="subtitle">DATOS CLÍNICOS</h4>

<div style="text-align: center; border: 1px solid gray; font-size: 10pt">
    <div style="margin: 1em">
        <span><b>Tipo de sangre: </b>{{$paciente->tipo_sangre}}</span>
        &nbsp;
        <span><b>Talla: </b>{{$paciente->talla}} cm</span>
    </div>
    <div>
        <table class="diagnostico">
            <tr>
                <td rowspan="2">Diagnóstico</td>
                <th>Diabetes Mellitus</th>
                <th>Hipertensión</th>
                <th>Obesidad</th>
                <th>Sobrepeso</th>
                <th>Otro</th>
            </tr>
            <tr>
                <td>[{{$paciente->diab_mill?"x":" "}}]</td>
                <td>[{{$paciente->hiper_t?"x":" "}}]</td>
                <td>[{{$paciente->obesidad?"x":" "}}]</td>
                <td>[{{$paciente->sobrepeso?"x":" "}}]</td>
                <td>{{$paciente->otro}}</td>
            </tr>
        </table>
    </div>
</div>

<h4 class="subtitle">SESIONES SUBSECUENTES</h4>

<table class="resumen">
    <tr>
        <th rowspan="2">Sesión</th>
        <th rowspan="2">Peso (kg)</th>
        <th rowspan="2">Pulso (fc)</th>
        <th rowspan="2">Cuello (cm)</th>
        <th rowspan="2">Cintura (cm)</th>
        <th rowspan="2">Cadera (cm)</th>
        <th rowspan="2">Muslo (cm)</th>
        <th colspan="2">Glucosa</th>
        <th colspan="2">T/A</th>
        <th rowspan="2">SpO<sub>2</sub> (%)</th>
    </tr>
    <tr>
        <td>mg/dL</td>
        <td>Ayuno</td>
        <td>(S)</td>
        <td>(D)</td>
    </tr>
    @foreach($paciente->sesiones() as $consulta)
        <tr>
            <td>{{$consulta['sesion']}}</td>
            <td>{{$consulta['peso']}}</td>
            <td>{{$consulta['pulso']}}</td>
            <td>{{$consulta['cuello']}}</td>
            <td>{{$consulta['cintura']}}</td>
            <td>{{$consulta['cadera']}}</td>
            <td>{{$consulta['muslo']}}</td>
            <td>{{$consulta['cant_glucosa']}}</td>
            <td>[{{$consulta['ayuno']?"x":" "}}]</td>
            <td>{{$consulta['ta_sist']}}</td>
            <td>{{$consulta['ta_diast']}}</td>
            <td>{{$consulta['oximetria']}}</td>
        </tr>
    @endforeach
</table>

<span class="page-break"></span>

<h4 class="subtitle">VISUALIZACIÓN DE LOS DATOS</h4>
<table class="graficas">
    <tr>
        <td style="width: 50%"><img width="320px" src='{{$request->get("peso")}}' alt='image'></td>
        <td style="width: 50%"><img width="320px" src='{{$request->get("medidas")}}' alt='image'></td>
    </tr>
    <tr>
        <td style="width: 50%"><img width="320px" src='{{$request->get("glucosa")}}' alt='image'></td>
        <td style="width: 50%"><img width="320px" src='{{$request->get("ta_diast")}}' alt='image'></td>
    </tr>
    <tr>
        <td style="width: 50%"><img width="320px" src='{{$request->get("ta_sist")}}' alt='image'></td>
        <td style="width: 50%"><img width="320px" src='{{$request->get("imc")}}' alt='image'></td>
    </tr>
    <tr>
        <td style="width: 50%"><img width="320px" src='{{$request->get("icc")}}' alt='image'></td>
        <td style="width: 50%"><img width="320px" src='{{$request->get("oximetria")}}' alt='image'></td>
    </tr>
</table>
</body>
</html>
