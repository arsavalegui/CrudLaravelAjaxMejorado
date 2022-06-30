
<h1> {{$modo}} equipo </h1>

@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>

@endif

<div class="form-group" >
    <label for="Nombre">Nombre del equipo</label>
    <input type="text" class="form-control" name="NombreEquipo" id="NombreEquipo" value="{{ isset($equipo->NombreEquipo)?$equipo->NombreEquipo:old('NombreEquipo') }}">
</div>

<div class="form-group" >
    <label for="ApellidoPaterno">Trabajo a realizar</label>
    <input type="text" class="form-control" name="TrabajoDelEquipo" id="TrabajoDelEquipo" value="{{ isset($equipo->TrabajoDelEquipo)?$equipo->TrabajoDelEquipo:old('TrabajoDelEquipo') }}">
</div>

<div class="form-group" >
    <label for="ApellidoMaterno">Nombre del lider del equipo</label>
    <input type="text" class="form-control" name="NombreDelLider" id="NombreDelLider" value="{{ isset($equipo->NombreDelLider)?$equipo->NombreDelLider:old('NombreDelLider') }}">
</div>

<div class="form-group" >
    <label for="Foto">Foto para el equipo</label>
    @if(isset($equipo->foto))
    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$equipo->Foto }}" width="150" alt="">
    @endif
    <input type="file" class="form-control" name="Foto" id="Foto" value="">
</div>

<br>

<input class="btn btn-success" type="submit" value="{{ $modo }} equipo">

<a class="btn btn-primary" href="{{ url('empleado/') }}">Regresar</a>