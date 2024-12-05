@extends('layouts.app')

@section('navigation')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Administrador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Eliminar usuarios</li>
        </ol>
    </nav>
@endsection

@section('content')
    <h1>Remover Usuarios</h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">Usuario</th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        @foreach(App\User::all() as $user)
            @if(\Illuminate\Support\Facades\Auth::user()->id !== $user->id)
                <tr>
                    <td class="text-center align-content-center">{{$user->name}}</td>
                    <td class="text-center"><a href='{{url("/admin/usuarios/eliminar/$user->id")}}'
                                               class="btn btn-danger">Eliminar</a></td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@endsection
