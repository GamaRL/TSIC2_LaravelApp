@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Administrador</h1>
    <div class="list-group">
        <a href="{{url('admin/consultas/export')}}" class="list-group-item list-group-item-action">
            Exportar Consultas (XSLX)
        </a>
        <a href="{{url('/admin/estadisticas/general')}}" class="list-group-item list-group-item-action">
            Estadísticas
        </a>
        <a href="{{url('/admin/pacientes/1')}}" class="list-group-item list-group-item-action">
            Ver pacientes en riesgo
        </a>
        <a href="{{route('register')}}" class="list-group-item list-group-item-action">
            Registrar Usuarios
        </a>
        <a href="{{url('/admin/usuarios/eliminar')}}" class="list-group-item list-group-item-action">
            Eliminar Usuarios
        </a>
        <a href="{{url('/admin/reportes')}}" class="list-group-item list-group-item-action">Reportes</a>
    </div>
@endsection
