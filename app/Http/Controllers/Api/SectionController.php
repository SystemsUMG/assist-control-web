<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return $this->jsonResponse($sections, true, 'Registros consultados exitosamente', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'letter' => ['string', 'required', 'max:255']
        ]);
        $sections = Section::create($validate);
        if($sections){
            $this->result = true;
            $this->message = 'Registro creado exitosamente.';
            $this->statusCode = 200;
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sections = Section::find($id);
        if($sections){
            $this->records = $sections;
            $this->result = true;
            $this->message = 'Registro consultado exitosamente.';
        } else {
            $this->message = 'No existe la seccion.';
        } 
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sections = Section::find($id);
        $validate = $request->validate([
            'letter' => ['string', 'required', 'max:255']
        ]);
        if($sections){
            $sections->update($validate);
            $this->result = true;
            $this->message = 'Registro actualizado exitosamente.';
        } else {
            $this->message = 'No existe la seccion.';
        }
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sections = Section::find($id);
       
        if($sections){
            $sections->delete();
            $this->result = true;
            $this->message = 'Borrado correctamente.';
        } else {
            $this->message = 'No existe la seccion.';
        }
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}
