<?php

namespace App\Http\Controllers\Api;

use App\Clases\Utilitat;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecursosResource;
use App\Models\Recursos;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recursos = Recursos::with('tipus_recurs')->with('usuaris')->get();
        return new RecursosResource($recursos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recurs = new Recursos();

        $recurs->codi = $request->input('codi');
        $recurs->tipus_recurs_id = $request->input('tipus_recurs_id');
        $recurs->id_usuario = $request->input('id_usuario');

        try
        {
            $recurs->save();
            $respuesta = (new RecursosResource($recurs))
                        ->response()
                        ->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::errorMessage($e);
            $respuesta = response()
                        ->json(['error' => $mensaje], 400);
        }
        return $respuesta;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recursos  $recursos
     * @return \Illuminate\Http\Response
     */
    public function show(Recursos $recursos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recursos  $recursos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idRecurs)
    {
        $recurs = Recursos::find($idRecurs);
        $recurs->codi = $request->input('codi');
        $recurs->tipus_recurs_id = $request->input('tipus_recurs_id');
        $recurs->id_usuario = $request->input('id_usuario');

        try
        {
            $recurs->save();
            $respuesta = (new RecursosResource($recurs))
                ->response()
                ->setStatusCode(200);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::errorMessage($e);

            $respuesta = response()
                ->json(['error' => $mensaje], 400);
        }

        return $respuesta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recursos  $recursos
     * @return \Illuminate\Http\Response
     */
    public function destroy($idRecurs)
    {
        $recurs = Recursos::find($idRecurs);
        if($recurs == null)
        {
            $respuesta = response()
                        ->json(['error'=>"¡ELEMENTO NO ENCONTRADO!"], 404);
        }
        else
        {
            try
            {
                $recurs->delete();
                $respuesta = (new RecursosResource($recurs))
                            ->response()
                            ->setStatusCode(200);
            }
            catch(QueryException $e)
            {
                $mensaje = Utilitat::errorMessage($e);
                $respuesta = response()
                            ->json(['error'=>$mensaje], 400);
            }
        }
        return $respuesta;
    }
}
