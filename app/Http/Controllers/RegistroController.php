<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;
use MongoDB\BSON\Decimal128;
use MongoDB\BSON\UTCDateTime as MongoDate;
use Storage;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = Registro::take(50)->get();

        $registrosConFormato = [];

        foreach ($registros as $registro) {
            $temperatura = $registro['temperatura'];
            $usoDeGel = $registro['usoDeGel'];
            $registro['temperatura'] = strval(new Decimal128($temperatura));
            $registro['usoDeGel'] = strval(new Decimal128($usoDeGel));
        }

        return response()->json(['mensaje'=>'exito', 'registros'=>$registros]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = "/imgs/sinMascarilla.png";

        if ($request->hasFile('foto')) {
            $foto = Storage::put('public', $request->foto);
            $url = Storage::url($foto);
        }

        Registro::create([
            'temperatura'=>new Decimal128($request->temperatura),
            'protocoloCompleto'=> $request->protocoloCompleto,
            'conMascarilla'=> $request->conMascarilla,
            'sinMascarilla'=> $request->sinMascarilla,
            'usoDeGel' => new Decimal128($request->usoDeGel),
            'foto'=> $url,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, registro $registro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(registro $registro)
    {
        //
    }

    /**
     * Devuelve los registros encontrados entre dos fechas específicas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtrarPorFechas(Request $request)
    {
        $fechaInicio = new MongoDate(date_create(date($request->fechaInicio)));
        $fechaFinal = new MongoDate(date_create(date($request->fechaFinal)));

        $registros = Registro::whereBetween(
            'created_at',
            [$fechaInicio, $fechaFinal]
        )->get();

        foreach ($registros as $registro) {
            $temperatura = $registro['temperatura'];
            $usoDeGel = $registro['usoDeGel'];
            $registro['temperatura'] = strval(new Decimal128($temperatura));
            $registro['usoDeGel'] = strval(new Decimal128($usoDeGel));
        }

        return response()->json(['message'=>'success', 'registros'=>$registros]);
    }
}
