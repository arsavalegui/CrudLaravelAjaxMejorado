
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
        <a href="{{ url('empleado/create') }}" class="btn btn-success" > Registrar nuevo empleado </a>
        <a href="{{ url('equipo/create') }}" class="btn btn-success" > Registrar nuevo equipo </a>
        <a href="{{ url('equipo') }}" class="btn btn-success" > Ver equipos actuales</a>
    </form>


    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($empleados as $empleado) <!-- Consultar informacion pasada en la variable empleados en el EmpleadoController en el metodo index -->
            <tr>
                <td>{{ $empleado->id }}</td>
                <td>
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" width="150" alt="">
                </td>
                <td>{{ $empleado->Nombre }}</td>
                <td>{{ $empleado->ApellidoPaterno }}</td>
                <td>{{ $empleado->ApellidoMaterno }}</td>
                <td>{{ $empleado->Correo }}</td>
                <td> 
                    
                    <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning" >
                        Editar
                    </a>

                    |
                    
                    <form action="{{ url('/empleado/'.$empleado->id) }}" method="post" class="d-inline" >
                        @csrf
                        {{ method_field('DELETE') }}
                        <input class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que desea borrar?')" value="Eliminar empleado">
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection