<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccesoRequest;
use App\Http\Requests\RegistroRequest;
use App\Jobs\EmailJob;
use App\Jobs\TareasJobs;
use App\Mail\ContactosMailable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //EmailJob::dispatch();

        $contactos = DB::table('contactos')->get();
        $contactosArray = $contactos->toArray();

        $emails = [];

        foreach ($contactosArray as $contacto){
            //EmailJob::dispatch($contacto->email);
            array_push($emails, $contacto->email);
        }

        Mail::to($emails)->send(new ContactosMailable());

        return response()->json([
           'res' => true,
           'msg' => 'Usuario registrado con exito'
        ], 200);
    }

    public function acceso(AccesoRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
               'email' => ['Las credenciales ingresadas son incorrectas!.']
            ]);
        }
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            'res' => true,
            'msg' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function cerrarSesion(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Token Eliminado Correctamente'
        ]);
    }
}
