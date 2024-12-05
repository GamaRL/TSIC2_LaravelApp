@extends('layouts.app')

@section('navigation')
    <nav class="nav">
        <a class="nav-link" href="{{url('/pacientes')}}">Todos</a>
        <a class="nav-link active" href="{{'/pacientes/create'}}">Crear Nuevo</a>
        <a class="nav-link active" href="{{"/pacientes/$paciente->id"}}">Ver Paciente</a>
    </nav>
@endsection

@section('content')
    <h1>Editar al usuario</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check"></i> Se ha actualizado con éxito
        </div>
    @endif

    <form action="{{url("/pacientes/$paciente->id/edit")}}" method="POST" autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="{{$paciente->nombre}}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre')
            <span class="invalid-feedback" role="alert">
			<strong>{{ $message }}</strong>
		</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="apPat">Apellido Paterno</label>
            <input type="text" value="{{$paciente->apPat}}" name="apPat" id="apPat"
                   class="form-control @error('apPat') is-invalid @enderror" value="{{ old('nombre') }}">
            @error('apPat')
            <span class="invalid-feedback" role="alert">
			<strong>{{ $message }}</strong>
		</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="apMat">Apellido Materno</label>
            <input type="text" value="{{$paciente->apMat}}" name="apMat" id="apMat"
                   class="form-control @error('apMat') is-invalid @enderror">
            @error('apMat')
            <span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
		    </span>
            @enderror
        </div>

        <div class="row">
            <div class="form-group col-12 col-md-6">
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                       class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                       value="{{ $paciente->fecha_nacimiento }}">
                @error('fecha_nacimiento')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="talla">Talla (cm):</label>
                <input type="number" id="talla" name="talla"
                       class="form-control @error('talla') is-invalid @enderror" value="{{$paciente->talla}}">
                @error('talla')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <input type="submit" value="Actualizar" class="btn btn-primary">
    </form>
@endsection
