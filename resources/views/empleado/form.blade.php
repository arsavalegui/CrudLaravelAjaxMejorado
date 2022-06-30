
<h1> {{$modo}} empleado </h1>

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
    <label for="Nombre">Nombre</label>
    <input type="text" class="form-control" name="Nombre" id="Nombre" value="{{ isset($empleado->Nombre)?$empleado->Nombre:old('Nombre') }}">
</div>

<div class="form-group" >
    <label for="ApellidoPaterno">ApellidoPaterno</label>
    <input type="text" class="form-control" name="ApellidoPaterno" id="ApellidoPaterno" value="{{ isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:old('ApellidoPaterno') }}">
</div>

<div class="form-group" >
    <label for="ApellidoMaterno">ApellidoMaterno</label>
    <input type="text" class="form-control" name="ApellidoMaterno" id="ApellidoMaterno" value="{{ isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:old('ApellidoMaterno') }}">
</div>

<div class="form-group" >
    <label for="Correo">Correo</label>
    <input type="text" class="form-control" name="Correo" id="Correo" value="{{ isset($empleado->Correo)?$empleado->Correo:old('Correo') }}">
</div>

<div class="form-group">
    <select name="" id="">
        
    </select>
</div>

<div class="form-group" >
    <label for="Foto">Foto</label>
    @if(isset($empleado->foto))
    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" width="150" alt="">
    @endif
    <input type="file" class="form-control" name="Foto" id="Foto" value="">
</div>

<br>

<input class="btn btn-success" type="submit" value="{{ $modo }} empleado">

<a class="btn btn-primary" href="{{ url('empleado/') }}">Regresar</a>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
</script>

<script>
    jQuery(document).ready(function(){
        jQuery('#Correo').focusout(function(e){
            e.preventDefault();
            console.log($('meta[name="csrf-token"]').attr('content'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#email-error').remove();
            jQuery.ajax({
                url: "{{ url('/empleados-store') }}",
                type: 'POST',
                data: {
                    Correo: jQuery('#Correo').val(),
                },
                success: function(data){

                if (data.success == false) {
                    $('#Correo').after('<div id="email-error" class="text-danger" <strong>'+data.message[0]+'<strong></div>');
                }else {
                    $('#Correo').after('<div id="email-error" class="text-success" <strong>'+data.message+'<strong></div>');
                }
            }});
        });
    });
</script>
