<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpleado;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Mail\Credenciales;
use Illuminate\Support\Facades\Mail;

class EmpleadoController extends Controller
{
    public function __construct()
    {

    }

    public function create(){
        return view('empleado/create');
    }


    public function store(StoreEmpleado $request){
        $empleado = new Empleado();
        $empleado -> nombre = $request -> nombre;
        $empleado -> ap = $request -> ap;
        $empleado -> am = $request -> am;
        $empleado -> genero = $request -> genero;
        $empleado -> fenac = $request -> fenac;
        $empleado -> feIng = $request -> feIng;
        $empleado -> direccion = $request -> direccion;
        $empleado -> telefono = $request -> telefono;
        $empleado -> email = $request -> email;
        $empleado -> contrasena = Hash::make($request->contrasena);
        $empleado -> profile_image = $request -> profile_image;

        //Enviar correo con la contraseña
        $contrasena = $request->contrasena;
        Mail::to($empleado->email)->send(new Credenciales($empleado -> nombre , $contrasena));

        $empleado -> save();

        $empleado->assignRole('empleado');
        return redirect(route('principal'));
    }


    public function consultarEmpleado(){
        $empleado= Empleado::all();
        return view('empleado/consultar-empleado',compact('empleado'));
    }


    public function edit($ide){
        $empleado=Empleado::find($ide); 
        return view('empleado/edit',compact('empleado'));
    }

    public function update(StoreEmpleado $request,$ide){
        $empleado = Empleado::find($ide);
        $empleado -> nombre = $request -> nombre;
        $empleado -> ap = $request -> ap;
        $empleado -> am = $request -> am;
        $empleado -> genero = $request -> genero;
        $empleado -> fenac = $request -> fenac;
        $empleado -> feIng = $request -> feIng;
        $empleado -> direccion = $request -> direccion;
        $empleado -> telefono = $request -> telefono;
        $empleado -> email = $request -> email;
        
        if (!empty($request->contrasena)) {
            $empleado->contrasena = Hash::make($request->contrasena);
            $contrasena = $request->contrasena;
            Mail::to($empleado->email)->send(new Credenciales($empleado -> nombre , $contrasena));
        }

        $empleado -> save();

        return redirect()->route('principal');
    }


    public function destroy($ide){
        $empleado = Empleado::find($ide);
        if($empleado){
            $empleado->delete();
            return response()->json(['message' => 'Empleado eliminado con éxito']);
        }else{
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
    }
}
