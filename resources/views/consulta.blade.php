@extends('layouts.app')

@section('navigation')
    <nav class="nav">
        <a class="nav-link" href="{{url('/pacientes')}}">Todos</a>
        <a class="nav-link" href="{{url('/pacientes/create')}}">Crear Nuevo</a>
        <a class="nav-link active" href="{{"/pacientes/$paciente->id"}}">Ver Paciente</a>
    </nav>
@endsection

@section('content')
    <h1>Consulta <span class="badge badge-secondary"># {{$paciente->consulta->count() + 1}}</span> de:</h1>
    <div class="h2 font-weight-bolder mb-3">{{$paciente->nombre}}</div>

    <form action="{{url("/pacientes/$paciente->id/consulta")}}" method="POST">
        @csrf
        <input type="hidden" name="paciente" value="{{$paciente->id}}">
        <input type="hidden" name="sesion" id="sesion" value="{{$paciente->consulta->count() + 1}}">
        <input type="hidden" name="diab_mill" value="{{$paciente->diab_mill}}">
        <div class="row">
            <div class="card border-success mb-3 col-12">
                <div class="card-body">
                    <div class="card-title h3">Medidas:</div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="peso" class="card-subtitle">Peso:</label>
                            <input type="number" step="0.01" id="peso" name="peso" autocomplete="false"
                                   class="form-control @error('peso') is-invalid @enderror"
                                   value="{{ old('peso') }}">
                            @error('peso')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror

                        </div>
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="pulso" class="card-subtitle">Pulso:</label>
                            <input type="number" id="pulso" name="pulso" autocomplete="false"
                                   class="form-control @error('pulso') is-invalid @enderror"
                                   value="{{ old('pulso') }}">
                            @error('pulso')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="cuello" class="card-subtitle">Cuello:</label>
                            <input type="number" step="0.01" id="cuello" name="cuello" autocomplete="false"
                                   class="form-control @error('cuello') is-invalid @enderror"
                                   value="{{ old('cuello') }}">
                            @error('cuello')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{--Cintura, cadera, muslo--}}

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="cintura" class="card-subtitle">Cintura:</label>
                            <input type="number" step="0.01" id="cintura" name="cintura" autocomplete="false"
                                   class="form-control @error('cintura') is-invalid @enderror"
                                   value="{{ old('cintura') }}">
                            @error('cintura')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="cadera" class="card-subtitle">Cadera:</label>
                            <input type="number" step="0.01" id="cadera" name="cadera" autocomplete="false"
                                   class="form-control @error('cadera') is-invalid @enderror"
                                   value="{{ old('cadera') }}">
                            @error('cadera')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="muslo" class="card-subtitle">Muslo:</label>
                            <input type="number" step="0.01" id="muslo" name="muslo" autocomplete="false"
                                   class="form-control @error('muslo') is-invalid @enderror"
                                   value="{{ old('muslo') }}">
                            @error('muslo')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="masa_grasa" class="card-subtitle">Masa grasa:</label>
                            <input type="number" step="0.01" id="masa_grasa" name="masa_grasa"
                                   class="form-control @error('masa_grasa') is-invalid @enderror"
                                   value="{{old('masa_grasa')}}">
                            @error('masa_grasa')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="masa_muscular" class="card-subtitle">Masa muscular:</label>
                            <input type="number" step="0.01" id="masa_muscular" name="masa_muscular"
                                   class="form-control @error('masa_muscular') is-invalid @enderror"
                                   @error('masa_muscular') class="is-invalid"
                                   @enderror value="{{old('masa_muscular')}}">
                            @error('masa_muscular')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="total_agua" class="card-subtitle">Total de agua:</label>
                            <input type="number" step="0.01" id="total_agua" name="total_agua"
                                   class="form-control @error('total_agua') is-invalid @enderror "
                                   value="{{old('total_agua')}}">

                            @error('total_agua')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container mb-3 col-md-6 col-12 ml-0 pr-md-3 p-0">
                <div class="card border-warning">
                    <div class="card-body">
                        <div class="card-title h3">Glucosa:</div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="cant_glucosa" class="card-subtitle">Cantidad:</label>
                                <input type="number" step="0.01" id="cant_glucosa" name="cant_glucosa"
                                       autocomplete="false"
                                       class="form-control @error('cant_glucosa') is-invalid @enderror"
                                       value="{{ old('cant_glucosa') }}">
                                @error('cant_glucosa')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="ayuno" class="card-subtitle">Ayuno:</label>
                                <select name="ayuno" id="ayuno"
                                        class="form-group custom-select @error('ayuno') is-invalid @enderror">
                                    <option value="0" {{ old('ayuno') === "1" ? "selected" : ""}}>No</option>
                                    <option value="1" {{ old('ayuno') === "0" ? "selected" : ""}}>Sí</option>
                                </select>
                                @error('ayuno')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mb-3 col-md-6 col-12 m-0 pl-md-3 p-0">
                <div class="card border-info">
                    <div class="card-body">
                        <div class="card-title h3">Tensión Arterial:</div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="ta_sist" class="card-subtitle">Sistólica:</label>
                                <input type="number" step="0.01" id="ta_sist" name="ta_sist" autocomplete="false"
                                       class="form-control @error('ta_sist') is-invalid @enderror"
                                       value="{{ old('ta_sist') }}">
                                @error('ta_sist')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="ta_diast" class="card-subtitle">Diastólica:</label>
                                <input type="number" step="0.01" id="ta_diast" name="ta_diast" autocomplete="false"
                                       class="form-control @error('ta_diast') is-invalid @enderror"
                                       value="{{ old('ta_diast') }}">
                                @error('ta_diast')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container mb-3 col-md-6 col-12 m-0 pr-md-3 p-0">
                <div class="card border-dark">
                    <div class="card-body">
                        <div class="card-title h3">Oximetría:</div>
                        <div class="row justify-content-around">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="oximetria" step="0.01" class="card-subtitle">Medida:</label>
                                <input type="number" id="oximetria" name="oximetria" autocomplete="false"
                                       class="form-control @error('oximetria') is-invalid @enderror"
                                       value="{{ old('oximetria') }}">
                                @error('oximetria')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mb-3 col-md-6 col-12 m-0 pl-md-3 py-5">
                <div class="row justify-content-center">
                    <button class="btn btn-primary col-12">Guardar</button>
                </div>
            </div>
        </div>
    </form>
@endsection
