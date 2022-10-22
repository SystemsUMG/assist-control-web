<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Career;
use Exception;
use Illuminate\Http\Request;

class CareerController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = Career::with('courses')->get();
            $this->result = true;
            $this->message = 'Carreras consultadas correctamente';
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
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
            'name'          => ['required', 'string'],
            'description'   => ['required', 'string']
        ]);
        try {
            $career = Career::create($validate);
            if ($career) {
                $this->result = true;
                $this->message = 'Carrera creada correctamente';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $career = Career::with('courses')->find($id);
            if ($career) {
                $this->records = $career;
                $this->result = true;
                $this->message = 'Carrera consultada correctamente';
            } else {
                $this->message = 'No existe la carrera';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
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
        $validate = $request->validate([
            'name'          => ['required', 'string'],
            'description'   => ['required', 'string']
        ]);
        try {
            $career = Career::find($id);
            if ($career) {
                $career->update($validate);
                $this->result = true;
                $this->message = 'Carrera actualizada correctamente';
            } else {
                $this->message = 'No existe la carrera';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
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
            $career = Career::find($id);
            if ($career) {
                $career->delete();
                $this->result = true;
                $this->message = 'Carrera eliminada correctamente';
            } else {
                $this->message = 'No existe la carrera';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }
}
