<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajustes;
use MongoDB\BSON\Decimal128;

class AjustesController extends Controller
{
    /**
     * Devuelve la vista de ajustes.
     */
    public function index()
    {
        return view('ajustes');
    }

    public function obtenerAjustes()
    {
        $ajustes = Ajustes::all();

        $ajuste = new Ajustes();
        $ajuste->_id = $ajustes[0]['_id'];
        $ajuste->temperatura =  strval(new Decimal128($ajustes[0]['temperatura']));

        return response()->json(['mensaje'=>'exito', 'ajustes'=>$ajuste]);
    }

    public function actualizar(Request $request)
    {
        Ajustes::where('_id', $request->_id)
        ->update([
            'temperatura' => new Decimal128($request->temperatura)
        ]);

        return response()->json(['mensaje'=>'exito']);
    }
}
