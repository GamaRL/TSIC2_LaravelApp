@extends('layouts.app')

@section('navigation')
    <nav class="nav">
        <a class="nav-link" href="{{url('/pacientes')}}">Todos</a>
        <a class="nav-link" href="{{'/pacientes/create'}}">Crear Nuevo</a>
        <a class="nav-link" href="{{url("/pacientes/$paciente->id/edit/")}}">Editar</a>
    </nav>
@endsection

@section('content')
    <script src="{{url('js/vendor/Chart.bundle.min.js')}}"></script>
    <script src="../js/pacienteOnly.js"></script>

    <div class="modal" id="mensajes-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url("/pacientes/$paciente->id/mensajes")}}"
                          method="post" id="mensajes-form" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="sesion">Sesión</label>
                            <select name="sesion" id="sesion" class="form-control custom-select"></select>
                            <div class="invalid-feedback">Example invalid feedback text</div>
                        </div>
                        <div class="form-group">
                            <label for="categoria" class="col-form-label">Categoría:</label>
                            <select name="categoria" id="categoria" class="form-control custom-select"></select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="mensaje" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje"></textarea>
                            <div class="invalid-feedback">Example invalid feedback text</div>
                        </div>
                    </form>
                    <div class="alert alert-success d-none" role="alert">
                        ¡Se ha guardado exitosamente!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="send-message" form="mensajes-form" class="btn btn-primary">
                        Guardar mensaje
                    </button>
                    <button class="btn btn-primary d-none" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>
        </div>
    </div>

    <h1>Paciente <span class="badge badge-pill badge-secondary">#{{$paciente->id}}</span></h1>

    <input type="hidden" id="paciente_id" value="{{$paciente->id}}">

    <h2>Datos personales</h2>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Nombre:</div>
        <div class="col-7">{{$paciente->nombre}} {{$paciente->apPat}} {{$paciente->apMat}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Edad:</div>
        <div class="col-7">{{(new DateTime())->diff(new DateTime($paciente->fecha_nacimiento))->y}} años</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Sexo:</div>
        <div class="col-7">{{($paciente->sexo === "M") ? "Hombre" : "Mujer"}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Teléfono:</div>
        <div class="col-7">{{$paciente->tel}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">C.U.R.P.:</div>
        <div class="col-7">{{$paciente->curp}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Asentamiento:</div>
        <div class="col-7">{{$paciente->asentamiento->nombre}} <span class="font-weight-bolder">(C.P. {{str_pad($paciente->asentamiento->cp ,5,'0', STR_PAD_LEFT)}})</span>
        </div>
    </div>

    <hr>

    <h2 class="mt-5">Datos clínicos</h2>

    <hr>

    <div class="row">
        <div class="col-3 font-weight-bold">Tipo de sangre:</div>
        <div class="col-9">{{$paciente->tipo_sangre}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-3 font-weight-bold">Talla:</div>
        <div class="col-9">
            {{$paciente->talla}} cm
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-3 font-weight-bold">Diagnóstico:</div>
        <div class="col-9">
            {{$paciente->getDiagnostico()}}
        </div>
    </div>

    <hr>

    <a href="{{url("pacientes/$paciente->id/consulta")}}" class="btn btn-primary">Nueva consulta</a>
    <button type="button" class="btn btn-secondary" id="mensaje-modal-button" data-toggle="modal"
            data-target="#mensajes-modal">
        Nuevo Mensaje
    </button>
    <form action="{{url("/pacientes/export/$paciente->id")}}" method="POST" class="d-inline-block">
        @csrf
        <input type="hidden" name="peso">
        <input type="hidden" name="medidas">
        <input type="hidden" name="glucosa">
        <input type="hidden" name="ta_sist">
        <input type="hidden" name="ta_diast">
        <input type="hidden" name="imc">
        <input type="hidden" name="icc">
        <input type="hidden" name="oximetria">
        <button type="submit" id="generar_reporte" class="btn btn-success disabled">Generar reporte</button>
    </form>

    <h2 class="my-3">Mensajes</h2>
    <div class="my-3">
        <div id="accordion">
            @foreach($paciente->get_mensajes() as $sesion => $mensajes)
                <div class="card">
                    <div class="card-header" id="heading{{$sesion}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$sesion}}"
                                    aria-expanded="true" aria-controls="collapse{{$sesion}}">
                                Sesión {{$sesion}}
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{$sesion}}" class="collapse" aria-labelledby="heading{{$sesion}}"
                         data-parent="#accordion">
                        <div class="card-body container">
                            @if (count($mensajes) > 0)
                                @foreach($mensajes as $tipo => $mensaje)
                                    <div class="mb-4">
                                        <h4 class="text-uppercase">{{$tipo}}</h4>
                                        <p>{{$mensaje}}</p>
                                    </div>
                                @endforeach
                            @else
                                <p>Aún no hay mensajes</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <h2 class="my-3">Gráficas</h2>
    <div class="my-3" id="graphs">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Del peso</h3>
            </div>

            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="pesos"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white text-center">
                <h3 class="mb-0">Medidas</h3>
            </div>
            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="medidas"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white text-center">
                <h3 class="mb-0">De la glucosa</h3>
            </div>

            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="glucosa"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white text-center">
                <h3 class="mb-0">De la tensión arterial</h3>
            </div>

            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="ta_sist"></canvas>
                    <canvas id="ta_diast"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-warning text-white text-center">
                <h3 class="mb-0">Índices</h3>
            </div>

            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="imc"></canvas>
                    <canvas id="icc"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0">Oximetría</h3>
            </div>

            <div class="card-body">
                <div class="col-12 col-md-6 mx-auto">
                    <canvas id="oximetria"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
