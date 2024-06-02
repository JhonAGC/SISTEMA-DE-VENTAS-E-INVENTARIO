<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\Cliente;
use GuzzleHttp\Client;

class ClienteController extends Controller
{

    public function index()
    {
        return Cliente::where('estado', 1)->get();
    }


    public function store(Request $request)
    {
        /* crear una nueva instancia del modelo Cliente */
        $Cliente = new Cliente();

        /* asignar a cada columna el valor que se obtine como parametro */
        $Cliente->nombre = $request->get('nombre');
        $Cliente->apePaterno = $request->get('apePaterno');
        $Cliente->apeMaterno = $request->get('apeMaterno');
        $Cliente->dni = $request->get('dni');

        /* guardar el los datos en el modelo */
        $Cliente->save();

        /* retornar el el modelo */
        return $Cliente;
    }


    public function show($id)
    {
        return Cliente::find($id);
    }


    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->nombre = $request->get('nombre');
        $cliente->apePaterno = $request->get('apePaterno');
        $cliente->apeMaterno = $request->get('apeMaterno');
        $cliente->dni = $request->get('dni');

        $cliente->save();
        return $cliente;
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->estado = 0;
        $cliente->save();
        return $cliente;
    }
}
