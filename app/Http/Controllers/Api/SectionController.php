<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;

class SectionController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->records = Section::all();
        $this->result = true;
        $this->message = 'Centros consultados exitosamente';
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'letter' => ['required', 'string', 'max:255']
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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $sections = Section::find($id);
        $validate = $request->validate([
            'letter' => ['required', 'string', 'max:255']
        ]);
        if($sections){
            $sections->update($validate);
            $this->result = true;
            $this->message = 'Registro actualizado exitosamente.';
        } else {
            $this->message = 'No existe la sección.';
        }
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $sections = Section::find($id);
            if($sections){
                $sections->delete();
                $this->result = true;
                $this->message = 'Borrado correctamente.';
            } else {
                $this->message = 'No existe la sección.';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }
}
