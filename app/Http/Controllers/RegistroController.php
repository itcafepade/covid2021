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

        //Ejecutando archivo del script
        $salida = exec('C:\Users\Leonel\face-mask-detector\face_detector.bat');

        //Leyendo el archivo txt
        $resultados = fopen("C:\Users\Leonel\\face-mask-detector\\resultados.txt", "r");
        $textoArchivo = fread($resultados, filesize("C:\Users\Leonel\\face-mask-detector\\resultados.txt"));
        fclose($resultados);

        //Cortando archivo en la parte de la imagen y el valor booleano de si tiene
        //mascarilla o no
        $archivoSeccionado = explode("\r\n", $textoArchivo);
        $conMascarilla = $archivoSeccionado[0]; //Booleano
        $imagenBase64 = $archivoSeccionado[1]; //Imagen Base64

        //Decodificando imagen
        $imagenFullBase64 = 'data:image/jpeg;base64,'.$imagenBase64;
        $pattern = '/data:image\/(.+);base64,(.*)/';
        preg_match($pattern, $imagenFullBase64, $matches);
        $imageExtension = $matches[1];

        // base64-encoded image data
        $encodedImageData = $matches[2];

        // Convirtiendo imagen
        $decodedImageData = base64_decode($encodedImageData);

        //Asignando nombre aleatorio a la imagen
        $nombreImagen = md5(time().uniqid());
        file_put_contents(base_path()."/public/storage/{$nombreImagen}.jpeg", $decodedImageData);

        $protocoloCompleto = false;
        $sinMascarilla = false;

        //Determinando si se cumplio todo el protocolo
        if ($conMascarilla == "true" && $request->usoDeGel > 0) {
            $conMascarilla = true;
            $protocoloCompleto = true;
            $sinMascarilla = false;
        }

        if ($conMascarilla == "true") {
            $conMascarilla = true;
            $sinMascarilla = true;
        } else {
            $conMascarilla = false;
            $sinMascarilla = false;
        }

        Registro::create([
            'temperatura'=>new Decimal128($request->temperatura),
            'protocoloCompleto'=> $protocoloCompleto,
            'conMascarilla'=> $conMascarilla,
            'sinMascarilla'=> $sinMascarilla,
            'usoDeGel' => new Decimal128($request->usoDeGel),
            'foto'=> '/storage/'.$nombreImagen.'.jpeg',
        ]);

        return response()->json(['mensaje'=>'exito']);
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
