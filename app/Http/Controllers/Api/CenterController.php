<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\CareerAssigned;
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
        $centers = Center::with('careers_assignments')->get();
        //Retornar informacion de carrera
        foreach ($centers as $center) {
            foreach ($center->careers_assignments as $career_assignment) {
                $career_assignment->career;
            }
        }

        $this->records = $centers;
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

        //Crear career assigned por cada carrera
        $assigned_career = New AssignedCareerController();
        if(!empty($request->careers_assignments)) {
            $careers = explode(',', $request->careers_assignments);
            foreach($careers as $career) {
                $assigned_career->storeCareerAssigned($center->id, $career);
            }
        }

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
        foreach ($center->careers_assignments as $career_assignment) {
            $career_assignment->career;
        }
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
            //Crear career assigned por cada carrera
            $assigned_career = New AssignedCareerController();
            $careers_assignments = CareerAssigned::where('center_id', $center->id)->get();
            //Vacio (se eliminan todos)
            if(empty($request->careers_assignments)) {
                //Eliminar todos los registros
                foreach($careers_assignments as $career_assignment) {
                    $assigned_career->destroyCareerAssigned($center->id, $career_assignment->career_id);
                }
            } else { //No vacio se deben eliminar los que no vengan y agregar los nuevos
                $careers = explode(',', $request->careers_assignments);
                $olds = [];
                $news = [];
                //Obtener ids de carreras nuevos
                foreach($careers as $career) {
                    if (!in_array($career, $careers_assignments->pluck('career_id')->toArray())) {
                        array_push($news, $career);
                    }
                }
                //Obtener ids a eliminar (los que no vienen en request)
                foreach($careers_assignments as $career_assignment) {
                    if (!in_array($career_assignment->career_id, $careers)) {
                        array_push($olds, $career_assignment->career_id);
                    }
                }
                //Borrar registros 
                if (!empty($olds)) {
                    foreach ($olds as $old) {
                        $assigned_career->destroyCareerAssigned($center->id, $old);
                    }
                }
                //Crear registros
                if (!empty($news)) {
                    foreach ($news as $new) {
                        $assigned_career->storeCareerAssigned($center->id, $new);
                    }
                }
            }

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
                $assigned_career = New AssignedCareerController();
                $careers_assignments = CareerAssigned::where('center_id', $center->id)->get();
                if (!empty($careers_assignments)) {
                    foreach($careers_assignments as $career_assignment) {
                        $assigned_career->destroyCareerAssigned($center->id, $career_assignment->career_id);
                    }
                }
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
