<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use Illuminate\Http\Request;

class VacanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Autorizamos el acceso al modelo solo a los reclutadores
        $this->authorize('ViewAny', Vacante::class);
        //Retornamos la vista
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Autorizamos el acceso al modelo solo a los reclutadores
        $this->authorize('create', Vacante::class);
        //Retornamos la vista
        return view('vacantes.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        return view('vacantes.show', [
            'vacante' => $vacante
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        // Autoriza en el Policy si el usuario autenticado es el mismo al que creo la vacante
        $this->authorize('update', $vacante);

        //dd($vacante);
        return view('vacantes.edit', [
            'vacante' => $vacante
        ]);
    }
}
