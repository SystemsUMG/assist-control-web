<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Center;
use Exception;
use Illuminate\Http\Request;

class CenterController extends ResponseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->records = Center::all();
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255']
        ]);
        $center = Center::create($validate);
        if($center){
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
        $center = Center::find($id);
        $this->statusCode = 200;
        if($center){
            $this->records = $center;
            $this->result = true;
            $this->message = 'Registro consultado exitosamente.';
        } else {
            $this->message = 'No existe el centro.';
        }
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
        $center = Center::find($id);
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255']
        ]);
        if($center){
            $center->update($validate);
            $this->result = true;
            $this->message = 'Registro actualizado exitosamente.';
        } else {
            $this->message = 'No existe el centro.';
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
        try {
            $center = Center::find($id);
            if($center){
                $center->delete();
                $this->result = true;
                $this->message = 'Borrado correctamente.';
            } else {
                $this->message = 'No existe el centro.';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }
}
