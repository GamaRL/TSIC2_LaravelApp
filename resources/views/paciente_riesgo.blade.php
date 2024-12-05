@extends('layouts.app')

@section('content')
    <h1>Paciente <span class="badge badge-pill badge-secondary">#{{$data['paciente']->id}}</span>
        (Sesión {{$data['curr']->sesion}})</h1>
    <h2>Datos personales</h2>
    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Nombre:</div>
        <div class="col-7">{{$data['paciente']->nombre}} {{$data['paciente']->apPat}} {{$data['paciente']->apMat}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Edad:</div>
        <div class="col-7">{{(new DateTime())->diff(new DateTime($data['paciente']->fecha_nacimiento))->y}} años</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Sexo:</div>
        <div class="col-7">{{$data['paciente']->sexo === 'M' ? 'Hombre' : 'Mujer'}}</div>
    </div>

    <hr>

    <div class="row">
        <div class="col-5 font-weight-bold">Talla:</div>
        <div class="col-7">
            {{$data['paciente']->talla}} cm
        </div>
    </div>

    @if ($data['curr']->diab_mill)
        <hr>
        <div class="row">
            <div class="col-5 font-weight-bold">El paciente padece diabetes</div>
        </div>
    @elseif($data['paciente']->diab_mill)
        <hr>
        <div class="row">
            <div class="col-5 font-weight-bold">El paciente ya fue diagnosticado con diabetes</div>
        </div>
    @endif

    <hr>

    <div class="row mt-3 mb-5">
        <a class="col-7" href="{{url("/pacientes/".$data["paciente"]->id)}}">Ver más</a>
    </div>
    @if(!$data["paciente"]->diab_mill && isset($data['alertas']['glucosa']))
        @if(strpos($data['alertas']['glucosa'], "Alta") !== false)
            <div class="d-flex justify-content-end my-3">
                <button class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Marcar como diabético
                </button>
            </div>

            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres hacer esto?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <a type="button" href="{{url("/admin/pacientes/diab_mill/".$data["paciente"]->id)}}"
                               class="btn btn-danger">Continuar</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="mb-3 d-flex justify-content-lg-end justify-content-around">
        <span class="font-weight-bolder">Alertas Acumuladas del Paciente: &nbsp</span>
        <span class="badge-primary badge-pill">
            &#128995
            @php
                echo $data['paciente']
                    ->consulta()
                    ->get()
                    ->reduce(
                        function($carry, $consulta){
                            return $carry + $consulta
                                ->alerta()
                                ->where('tipo','glucosa')
                                ->count();
                        },0);
            @endphp
        </span>

        <span class="badge-primary badge-pill">
            &#128308
            @php
                echo $data['paciente']
                    ->consulta()
                    ->get()
                    ->reduce(
                        function($carry, $consulta){
                            return $carry + $consulta
                                ->alerta()
                                ->whereIn('tipo', ['ta_sist','ta_diast'])
                                ->count();
                        },0);
            @endphp
        </span>

        <span class="badge-primary badge-pill">
            &#128993
            @php
                echo $data['paciente']
                    ->consulta()
                    ->get()
                    ->reduce(
                        function($carry, $consulta){
                            return $carry + $consulta
                                ->alerta()
                                ->where('tipo','imc')
                                ->count();
                        },0);
            @endphp
        </span>

        <span class="badge-primary badge-pill">
            &#128310
            @php
                echo $data['paciente']
                    ->consulta()
                    ->get()
                    ->reduce(
                        function($carry, $consulta){
                            return $carry + $consulta
                                ->alerta()
                                ->where('tipo','icc')
                                ->count();
                        },0);
            @endphp
        </span>
    </div>


    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">Medida</th>
            <th scope="col">Última sesión</th>
            <th scope="col">Sesión anterior</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">Glucosa</th>
            <td>
                {{$data['curr']->cant_glucosa}} ({{$data['curr']->ayuno ? "En ayuno" : "Sin ayuno"}})
                @if (isset($data['alertas']['glucosa']))
                    <span class="text-danger font-weight-bolder">*{{$data['alertas']['glucosa']}}</span>
                @endif
            </td>
            <td>
                @if($data['prev'] !== null)
                    {{$data['prev']->cant_glucosa}} ({{$data['prev']->ayuno ? "En ayuno" : "Sin ayuno"}})
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row">Índice de Masa Corporal</th>
            <td>
                {{bcdiv($data['curr_imc'],'1',2)}} &nbsp;
                @if (isset($data['alertas']['imc']))
                    <span class="text-danger font-weight-bolder">*{{$data['alertas']['imc']}}</span>
                @endif
            </td>
            <td>
                @if ($data['prev_imc'] !== null)
                    {{bcdiv($data['prev_imc'], '1', 2)}}
                @endif
            </td>
        </tr>

        <tr>
            <th scope="row">Tensión Arterial Sistólica</th>
            <td>
                {{$data['curr']->ta_sist}} &nbsp;
                @if (isset($data['alertas']['ta_sist']))
                    <span class="text-danger font-weight-bolder">*{{$data['alertas']['ta_sist']}}</span>
                @endif
            </td>
            <td>
                @if($data['prev'] !== null)
                    {{$data['prev']->ta_sist}}
                @endif
            </td>
        </tr>

        <tr>
            <th scope="row">Tensión Arterial Diastólica</th>
            <td>
                {{$data['curr']->ta_diast}} &nbsp;
                @if (isset($data['alertas']['ta_diast']))
                    <span class="text-danger font-weight-bolder">*{{$data['alertas']['ta_diast']}}</span>
                @endif
            </td>
            <td>
                @if($data['prev'] !== null)
                    {{$data['prev']->ta_diast}}
                @endif
            </td>
        </tr>

        <tr>
            <th scope="row">índice Cintura Cadera</th>
            <td>
                {{bcdiv($data['curr_icc'], '1', 2)}} &nbsp;
                @if (isset($data['alertas']['icc']))
                    <span class="text-danger font-weight-bolder">*{{$data['alertas']['icc']}}</span>
                @endif
            </td>
            <td>
                @if($data['prev_icc'] !== null)
                    {{bcdiv($data['prev_icc'],'1',2)}}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

@endsection
