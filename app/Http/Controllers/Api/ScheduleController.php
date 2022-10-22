<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::all();
        return $this->jsonResponse($schedules, true, 'Registros consultados exitosamente', 200);
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
            'begin_hour' => ['date_format:H:i', 'required'],
            'end_hour' => ['date_format:H:i', 'required']
        ]);
        $schedules = Schedule::create($validate);
        if($schedules){
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
        $schedules = Schedule::find($id);
        $this->statusCode = 200;
        if($schedules){
            $this->records = $schedules;
            $this->result = true;
            $this->message = 'Registro consultado exitosamente.';
        } else {
            $this->message = 'No existe el horario.';
        } 
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
        $schedules = Schedule::find($id);
        $validate = $request->validate([
            'begin_hour' => ['date_format:H:i', 'required'],
            'end_hour' => ['date_format:H:i', 'required']
        ]);
        if($schedules){
            $schedules->update($validate);
            $this->result = true;
            $this->message = 'Registro actualizado exitosamente.';
        } else {
            $this->message = 'No existe el horario.';
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
        $schedules = Schedule::find($id);
       
        if($schedules){
            $schedules->delete();
            $this->result = true;
            $this->message = 'Borrado correctamente.';
        } else {
            $this->message = 'No existe el horario.';
        }
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}
