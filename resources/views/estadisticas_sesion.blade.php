@extends('layouts.app')

@section('navigation')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Administrador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Estadísticas</li>
        </ol>
    </nav>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{'/admin/estadisticas/general'}}">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{url('/admin/estadisticas/sesion')}}">Por sesión</a>
        </li>
    </ul>
@endsection

@section('content')
    <script src="{{url('js/vendor/Chart.bundle.min.js')}}"></script>

    <h1>Estadísticas por sesión</h1>

    <div class="row my-5">
        <div class="input-group justify-content-center mb-2">
            <select name="sesion" id="sesion" class="custom-select form-control col-6 col-md-3">
                @for($i=1; $i<=App\Consulta::max('sesion'); $i++)
                    <option value="{{$i}}">Sesión {{$i}}</option>
                @endfor
            </select>
            <div class="input-group-prepend">
                <button class="btn btn-primary" id="search">Buscar</button>
            </div>
        </div>
    </div>

    <div class="row my-5 justify-content-center d-none" id="graph-container">
        <canvas style="max-width: 80%" id="glucosa"></canvas>
        <canvas style="max-width: 80%" id="ta_sist"></canvas>
        <canvas style="max-width: 80%" id="ta_diast"></canvas>
        <canvas style="max-width: 80%" id="diabetes"></canvas>
    </div>
    <script src="{{url('js/statistics.js')}}"></script>
@endsection
