<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Equipo;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //get
    {
        //
        $datos['empleados']=Empleado::paginate(); //Consultar la informacion y se toman 5 registros, la variable es empleados la cual permite acceder a estps datos a taves del index
        return view('empleado.index', $datos); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        //
        $datos['equipos']=Equipo::paginate();
        return view('empleado.create', ['empleados.form', $datos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000',
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida',
        ]; 

        $this->validate($request, $campos, $mensaje); //Accede al metodo en que me encuentro o sus aprametros, reques, campos, mensaje

        $datosEmpleado = request()->except('_token');

        if($request->hasFile('Foto')){
            $datosEmpleado['Foto'] = $request->file('Foto') ->store('uploads','public');
        }

        Empleado::insert($datosEmpleado);

        //return response()->json($datosEmpleado);

        return redirect('empleado')->with('mensaje', 'Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado=Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
        ]; 

        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:10000'];
            $mensaje=['Foto.required'=>'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);

        //
        $datosEmpleado = request()->except(['_token', '_method']);

        if($request->hasFile('Foto')){
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto'] = $request->file('Foto') ->store('uploads','public');
        }

        Empleado::where('id','=',$id)->update($datosEmpleado);
        $empleado = Empleado::findOrFail($id);

        //return view('empleado.edit', compact('empleado'));

        return redirect('empleado')->with('mensaje', 'Empleado editado con exito'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $empleado = Empleado::findOrFail($id);

        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }

        return redirect('empleado')->with('mensaje', 'Empleado eliminado con exito'); 
    }

    public function ajax(Request $request){
        
        $input = $request->only(['Correo']);

        $request_data = [
            'Correo' => 'required|email|unique:empleados,Correo',
        ];

        $validator = Validator::make($input, $request_data);

        // json is null
        if ($validator->fails()) {
            $errors = json_decode(json_encode($validator->errors()), 1);
            return response()->json([
                'success' => false,
                'message' => array_reduce($errors, 'array_merge', array()),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'The email is available'
            ]);
        }
    }

    public function getTeamName(){
        //
        $datos['equipos']=Equipo::paginate();

        return view('empleado.form', $datos);
    }
}

