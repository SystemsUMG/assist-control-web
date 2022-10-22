<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Semester;
use Exception;
use Illuminate\Http\Request;

class SemesterController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = Semester::all();
            $this->result = true;
            $this->message = 'Semestres consultados correctamente';
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
            'number'        => ['required', 'integer'],
            'year'          => ['required', 'date_format:Y'],
            'begin_date'    => ['required', 'date_format:Y-m-d'],
            'end_date'      => ['required', 'date_format:Y-m-d'],
        ]);
        try {
            $semester = Semester::create($validate);
            if ($semester) {
                $this->result = true;
                $this->message = 'Semestre creado correctamente';
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
            $semester = Semester::find($id);
            if ($semester) {
                $this->records = $semester;
                $this->result = true;
                $this->message = 'Semestre consultado correctamente';
            } else {
                $this->message = 'No existe el semestre';
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
            'number'        => ['required', 'integer'],
            'year'          => ['required', 'date_format:Y'],
            'begin_date'    => ['required', 'date_format:Y-m-d'],
            'end_date'      => ['required', 'date_format:Y-m-d'],
        ]);
        try {
            $semester = Semester::find($id);
            if ($semester) {
                $semester->update($validate);
                $this->result = true;
                $this->message = 'Semestre actualizado correctamente';
            } else {
                $this->message = 'No existe el semestre';
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
            $semester = Semester::find($id);
            if ($semester) {
                $semester->delete();
                $this->result = true;
                $this->message = 'Semestre eliminado correctamente';
            } else {
                $this->message = 'No existe el semestre';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }
}
