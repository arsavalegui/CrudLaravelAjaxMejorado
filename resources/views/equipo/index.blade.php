
@extends('layouts.app')

@section('content')
<div class="container">
    
        @if(Session::has('mensaje'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('mensaje') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif 

    <form action="" class="d-inline">
        <a href="{{ url('equipo/create') }}" class="btn btn-success" > Registrar nuevo equipo </a>
        <a href="{{ url('empleado') }}" class="btn btn-success" > Regresar </a>
    </form>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre del equipo</th>
                <th>Lider del equipo</th>
                <th>Trabajo del equipo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($equipos as $equipo) <!-- Consultar informacion pasada en la variable empleados en el EmpleadoController en el metodo index -->
            <tr>
                <td>{{ $equipo->id }}</td>
                <td>
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$equipo->Foto }}" width="150" alt="">
                </td>
                <td>{{ $equipo->NombreEquipo }}</td>
                <td>{{ $equipo->NombreDelLider }}</td>
                <td>{{ $equipo->TrabajoDelEquipo }}</td>
                <td> 
                    
                    <a href="{{ url('/equipo/'.$equipo->id.'/edit') }}" class="btn btn-warning" >
                        Editar
                    </a>

                    |
                    
                    <form action="{{ url('/equipo/'.$equipo->id) }}" method="post" class="d-inline" >
                        @csrf
                        {{ method_field('DELETE') }}
                        <input class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que desea borrar?')" value="Eliminar equipo">
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection