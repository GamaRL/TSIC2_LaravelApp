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
            <a class="nav-link active" href="{{'/admin/estadisticas/general'}}">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/admin/estadisticas/sesion')}}">Por sesión</a>
        </li>
    </ul>
@endsection

@section('content')
    <script src="{{url('js/vendor/Chart.bundle.min.js')}}"></script>

    <h1>Estadísticas Generales</h1>

    <div class="d-flex align-items-center mt-5 col-12 col-md-6" id="loading">
        <strong>Cargando...</strong>
        <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
    </div>

    <section class="mt-5 d-none" id="graph-diabetes">
        <h2>Diabetes</h2>
        <div class="row my-5 justify-content-center">
            <canvas style="max-width: 80%" id="diabeticos"></canvas>
            <canvas style="max-width: 80%" id="prediabeticos"></canvas>
            <canvas style="max-width: 80%" id="normales"></canvas>
        </div>
    </section>
    <section class="mt-5 d-none" id="graph-alertas">
        <h2>Alertas</h2>
        <div class="row my-5 justify-content-center">
            <canvas style="max-width: 80%" id="glucosa"></canvas>
            <canvas style="max-width: 80%" id="tension"></canvas>
            <canvas style="max-width: 80%" id="icc"></canvas>
            <canvas style="max-width: 80%" id="imc"></canvas>
        </div>
    </section>
    <script src="{{url('js/statisticsGeneral.js')}}"></script>
@endsection
