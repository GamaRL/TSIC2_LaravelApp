@extends('layouts.app')

@section('navigation')
    <nav class="nav">
        <a class="nav-link active" href="{{url('/pacientes')}}">Todos</a>
        <a class="nav-link" href="{{'/pacientes/create'}}">Crear Nuevo</a>
    </nav>
@endsection

@section('content')
    <link rel="stylesheet" href="{{url('css/vendor/dataTables.bootstrap4.min.css')}}">

    <script src="{{url('js/vendor/jquery.min.js')}}"></script>
    <script src="{{url('js/vendor/jquery.dataTables.min.js')}}" defer></script>
    <script src="{{url('js/vendor/dataTables.bootstrap4.min.js')}}" defer></script>
    <script src="{{url('/js/findPaciente.js')}}"></script>

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
                    <form method="post" id="mensajes-form"
                          action="{{url("/pacientes/mensajes")}}" novalidate>
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

    <h1>Pacientes</h1>

    <button type="button" class="btn btn-secondary" id="mensaje-modal-button" data-toggle="modal"
            data-target="#mensajes-modal">
        Nuevo Mensaje
    </button>
    <div class="table-responsive col-12 m-0 p-3">
        <table class="table table-striped table-bordered table-hover"
				id="information" style="width: 100%">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="text-center align-middle">#</th>
                <th scope="col" class="text-center align-middle">Nombre</th>
                <th scope="col" class="text-center align-middle">Ap. Paterno</th>
                <th scope="col" class="text-center align-middle">Ap. Materno</th>
                <th scope="col" class="text-center align-middle">&#128270</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
