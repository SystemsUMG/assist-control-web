<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = Schedule::all();
        foreach ($schedules as $schedule) {
            //Formato a horas
            $schedule->begin_hour = $this->formatTime($schedule->begin_hour);
            $schedule->end_hour   = $this->formatTime($schedule->end_hour);
        }
        $this->records = $schedules;
        $this->result = true;
        $this->message = 'Horarios consultados exitosamente';
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
            'begin_hour' => ['required', 'date_format:H:i'],
            'end_hour' => ['required', 'date_format:H:i']
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $schedule = Schedule::find($id);
        //Formato a horas
        $schedule->begin_hour = $this->formatTime($schedule->begin_hour);
        $schedule->end_hour   = $this->formatTime($schedule->end_hour);
        $this->statusCode = 200;
        if($schedule){
            $this->records = $schedule;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        $validate = $request->validate([
            'begin_hour' => ['required', 'date_format:H:i'],
            'end_hour' => ['required', 'date_format:H:i']
        ]);
        if($schedule){
            $schedule->update($validate);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $schedule = Schedule::find($id);
            if($schedule){
                $schedule->delete();
                $this->result = true;
                $this->message = 'Borrado correctamente.';
            } else {
                $this->message = 'No existe el horario.';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }

    /**
     * Format time hour.
     *
     * @return String
     */
    public function formatTime(String $time)
    {
        return substr($time, 0, 5);
    }
}
