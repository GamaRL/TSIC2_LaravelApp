@extends('layouts.app')

@section('navigation')
    <nav class="nav">
        <a class="nav-link" href="{{url('/pacientes')}}">Todos</a>
        <a class="nav-link active" href="{{'/pacientes/create'}}">Crear Nuevo</a>
    </nav>
@endsection

@section('content')
    <div class="container">
        <h1>Crear Nuevo Paciente</h1>

        <div id="scanner"></div>

        <div id="scanner"></div>

        <form action="{{url('/pacientes')}}" method="POST" autocomplete="off">
            @csrf

            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}">
                    @error('nombre')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="apPat">Apellido Paterno:</label>
                    <input type="text" id="apPat" name="apPat" class="form-control @error('apPat') is-invalid @enderror"
                           value="{{ old('apPat') }}">
                    @error('apPat')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-4">
                    <label for="apMat">Apellido Materno:</label>
                    <input type="text" id="apMat" name="apMat" class="form-control @error('apMat') is-invalid @enderror"
                           value="{{ old('apMat') }}">
                    @error('apMat')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6 col-md-3">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                           class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                           value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-3">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo"
                            class="form-control custom-select @error('sexo') is-invalid @enderror">
                        <option value="M" {{ old('sexo') === "M" ? "selected" : ""}}>Masculino</option>
                        <option value="F" {{ old('sexo') === "F" ? "selected" : ""}}>Femenino</option>
                    </select>

                    @error('sexo')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-3">
                    <label for="curp">C.U.R.P.:</label>
                    <input type="text" id="curp" name="curp" maxlength="18" min="18" class="form-control @error('curp') is-invalid @enderror"
                           value="{{old('curp')}}">
                    @error('curp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-3">
                    <label for="tel">Teléfono:</label>
                    <input type="number" id="tel" name="tel" maxlength="10" min="0"
                           class="form-control @error('tel') is-invalid @enderror" value="{{old('tel')}}">

                    @error('tel')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-3">
                    <label for="cp">Código postal:</label>
                    <input type="number" id="cp" name="cp" list="cp_registered" maxlength="5" minlength="5"
                           class="form-control @error('cp') is-invalid @enderror" value="{{old('cp')}}">

                    <datalist id="cp_registered">
                        @foreach(\App\Asentamiento::distinct('cp')->get('cp') as $asentamiento)
                            <option>{{$asentamiento->cp}}</option>
                        @endforeach
                    </datalist>

                    @error('cp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-sm-6 col-md-3 @if(old('nuevo_asentamiento', 'off') === 'on') d-none @endif" id="asentamiento-lista">
                    <label for="nombre_asentamiento">Asentamiento:</label>
                    <select
                        name="asentamiento_id"
                        id="asentamiento_id"
                        type="text"
                        class="form-control custom-select @error('asentamiento_id') is-invalid @enderror"
                    >
                        <option value="">Seleccione...</option>
                        @foreach(\App\Asentamiento::all() as $asentamiento)
                            <option
                                value="{{$asentamiento->id}}"
                                data-cp="{{$asentamiento->cp}}"
                                @if(old('asentamiento_id') == $asentamiento->id)
                                    selected
                                @endif
                            >
                                {{$asentamiento->nombre}}
                            </option>
                        @endforeach
                    </select>
                    @error('asentamiento_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-12 col-md-3 align-items-center @if(old('nuevo_asentamiento', 'off') === 'off') d-none @endif" id="nuevo-asentamiento">
                    <label for="nombre_nuevo_asentamiento">Nuevo Asentamiento:</label>
                    <input
                        type="text"
                        name="nombre_nuevo_asentamiento"
                        id="nombre_nuevo_asentamiento"
                        class="form-control @error('nombre_nuevo_asentamiento') is-invalid @enderror"
                        value="{{old('nombre_nuevo_asentamiento')}}"
                    >
                    @error('nombre_nuevo_asentamiento')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-12 col-md-3 d-flex align-items-center">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="nuevo_asentamiento" name="nuevo_asentamiento"
                               @if(old('nuevo_asentamiento', 'off') === 'on') checked @endif>
                        <label class="custom-control-label" for="nuevo_asentamiento">¿Nuevo?</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2>Datos Clínicos del Paciente</h2>
                    <small>Seleccione únicamente los padecimientos del paciente</small>

                    <div class="form-group mt-3">
                        <h5>Diabetes Milletus</h5>
                        <label for="diab_mill-true">Sí</label>
                        <input type="radio" name="diab_mill" id="diab_mill-true" value="1"
                               @if (old('diab_mill')) checked @endif>

                        <label for="diab_mill-false" class="ml-3">No</label>
                        <input type="radio" name="diab_mill" id="diab_mill-false" value="0"
                               @error('diab_mill') class="is-invalid" @enderror @if (!old('diab_mill')) checked @endif>

                        @error('diab_mill')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h5>Hipertensión</h5>
                        <label for="hiper_t-true">Sí</label>
                        <input type="radio" name="hiper_t" id="hiper_t-true" value="1"
                               @if (old('hiper_t')) checked @endif>

                        <label for="hiper_t-false" class="ml-3">No</label>
                        <input type="radio" name="hiper_t" id="hiper_t-false" value="0"
                               @error('hiper_t') class="is-invalid" @enderror @if (!old('hiper_t')) checked @endif>

                        @error('hiper_t')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h5>Obesidad</h5>
                        <label for="obesidad-true">Sí</label>
                        <input type="radio" name="obesidad" id="obesidad-true" value="1"
                               @if (old('obesidad')) checked @endif>

                        <label for="obesidad-false" class="ml-3">No</label>
                        <input type="radio" name="obesidad" id="obesidad-false" value="0"
                               @error('obesidad') class="is-invalid" @enderror @if (!old('obesidad')) checked @endif>

                        @error('obesidad')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <h5>Sobrepeso</h5>
                        <label for="sobrepeso-true">Sí</label>
                        <input type="radio" name="sobrepeso" id="sobrepeso-true" value="1"
                               @if (old('sobrepeso')) checked @endif>
                        <label for="sobrepeso-false" class="ml-3">No</label>
                        <input type="radio" name="sobrepeso" id="sobrepeso-false" value="0"
                               @error('sobrepeso') class="is-invalid" @enderror @if (!old('sobrepeso')) checked @endif>

                        @error('sobrepeso')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="otro">Otro:</label>
                        <input type="text" name="otro" id="otro" class="form-control" value="{{old('otro')}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_sangre">Tipo de sangre: </label>
                        <select name="tipo_sangre" id="tipo_sangre" class="form-control custom-select">
                            @foreach(['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-'] as $tipo)
                                <option value="{{$tipo}}" @if($tipo == old('tipo_sangre')) selected @endif >{{$tipo}}</option>
                            @endforeach
                        </select>
                    </div>

                    <h2>Medidas del paciente</h2>

                    <div class="form-group">
                        <label for="talla">Talla (cm):</label>
                        <input type="number" id="talla" name="talla"
                               class="form-control @error('talla') is-invalid @enderror" value="{{old('talla')}}">
                        @error('talla')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary form-control" value="Enviar">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{url('js/nuevoPaciente.js')}}"></script>
@endsection
