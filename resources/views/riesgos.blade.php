@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <script src="{{url('js/vendor/jquery.min.js')}}"></script>
    <script src="{{url('js/vendor/jquery.dataTables.min.js')}}" defer></script>
    <script src="{{url('js/vendor/dataTables.bootstrap4.min.js')}}" defer></script>
    <script src="{{url("/js/findPacienteRiesgo.js")}}"></script>

    <h1><span class="font-weight-bolder">Pacientes en Riesgo</span> (Sesión {{$sesion}})</h1>

    <div class="row my-3">
        <div class="col-md-6 col-12">
            <ul class="list-unstyled">
                <li><span style="font-size: 20px; font-weight: bolder">🟣</span> Alerta Glucosa</li>
                <li><span style="font-size: 20px; font-weight: bolder">🟡</span> Alerta IMC</li>
                <li><span style="font-size: 20px; font-weight: bolder">🔴</span> Alerta de Presión</li>
                <li><span style="font-size: 20px; font-weight: bolder">🔶</span> Alerta de ICC</li>
            </ul>
        </div>
        <div class="col-md-6 col-12">
            <select name="sesion" id="sesion" class="custom-select">
                @foreach(range(1, $max_sesion) as $ses)
                    <option value="{{$ses}}" @if($ses == $sesion) selected @endif>Sesión {{$ses}}</option>
                @endforeach
            </select>
            <div class="d-flex justify-content-center">
                <a href="{{url("admin/alertas/$sesion")}}" class="btn btn-primary mt-3">Exportar</a>
            </div>
        </div>
        <script>
            document.getElementById('sesion').addEventListener('change', (e) => {
                window.location = `/admin/pacientes/${document.getElementById('sesion').value}`;
            })
        </script>
    </div>

    <div class="table-responsive col-12 m-0 pt-3">
        <table class="table table-striped table-bordered w-100" id="information">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="text-center align-middle">#</th>
                <th scope="col" class="text-center align-middle">Nombre</th>
                <th scope="col" class="text-center align-middle">Ap. Paterno</th>
                <th scope="col" class="text-center align-middle">Ap. Materno</th>
                <th scope="col" class="text-center align-middle">Alertas</th>
                <th scope="col" class="text-center align-middle">Ver Más</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

@endsection
