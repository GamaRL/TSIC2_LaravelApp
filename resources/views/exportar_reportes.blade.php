@extends('layouts.app')

@section('navigation')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Administrador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reportes</li>
        </ol>
    </nav>
@endsection

@section('content')
    <h1>Generar reporte PDF</h1>
    <div class="row d-flex align-content-center">
        <div class="ml-auto">
            {{$pacientes->render()}}
        </div>
        <div class="mr-auto">
            <a href="{{url((clone $pacientes)->appends(['generate'=>1])->url($pacientes->currentPage()))}}"
               class="btn btn-success">
                Obtener reporte
            </a>
        </div>
    </div>
    <div class="table-responsive col-12 m-0 p-3">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" role="button">
                    <a href="{{url((clone $pacientes)->appends(['order'=>'id'])->url($pacientes->currentPage()))}}"
                       class="d-block w-100">
                        ID
                        @if($orderBy === 'id')
                            <span class="arrow">&#8595;</span>
                        @endif
                    </a>
                </th>
                <th scope="col" role="button">
                    <a href="{{url((clone $pacientes)->appends(['order'=>'nombre'])->url($pacientes->currentPage()))}}"
                       class="d-block w-100">
                        Nombre
                        @if($orderBy === 'nombre')
                            <span class="arrow">&#8595;</span>
                        @endif
                    </a>
                </th>
                <th scope="col" role="button">
                    <a href="{{url((clone $pacientes)->appends(['order'=>'ap'])->url($pacientes->currentPage()))}}"
                       class="d-block w-100">
                        Apellidos
                        @if($orderBy === 'ap')
                            <span class="arrow">&#8595;</span>
                        @endif
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($pacientes as $paciente)
                <tr>
                    <th scope="row">{{$paciente->id}}</th>
                    <td>{{$paciente->nombre}}</td>
                    <td>{{$paciente->apPat}} {{$paciente->apMat}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="mx-auto">
            {{$pacientes->render()}}
        </div>
    </div>




@endsection
