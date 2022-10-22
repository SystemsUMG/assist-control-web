<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\CareerAssigned;
use Exception;
use Illuminate\Http\Request;

class AssignedCareerController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $assigned_careers = CareerAssigned::all();
            foreach ($assigned_careers as $assigned_career) {
                $this->records[] = [
                    'id'            => $assigned_career->id,
                    'center_id'     => $assigned_career->center_id,
                    'career_id'     => $assigned_career->career_id,
                    'center_name'   => $assigned_career->center->name,
                    'career_name'   => $assigned_career->career->name,
                ];
            }
            $this->result = true;
            $this->message = 'Datos consultados correctamente';
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
            'center_id' => ['required', 'integer', 'exists:centers,id'],
            'career_id' => ['required', 'integer', 'exists:careers,id']
        ]);
        try {
            $assigned_career = CareerAssigned::create($validate);
            if ($assigned_career) {
                $this->result = true;
                $this->message = 'Asignación creada correctamente';
                $this->statusCode = 200;
            }
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
            $assigned_career = CareerAssigned::find($id);
            if ($assigned_career) {
                $assigned_career['center_name'] = $assigned_career->center->name;
                $assigned_career['career_name'] = $assigned_career->career->name;
                $this->records = $assigned_career;
                $this->result = true;
                $this->message = 'Asignación consultada correctamente';
            } else {
                $this->message = 'No existe la asignación';
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
            'center_id' => ['required', 'integer', 'exists:centers,id'],
            'career_id' => ['required', 'integer', 'exists:careers,id']
        ]);
        try {
            $assigned_career = CareerAssigned::find($id);
            if ($assigned_career) {
                $assigned_career->update($validate);
                $this->result = true;
                $this->message = 'Asignación actualizada correctamente';
            } else {
                $this->message = 'No existe la asignación';
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
            $assigned_career = CareerAssigned::find($id);
            if ($assigned_career) {
                $assigned_career->delete();
                $this->result = true;
                $this->message = 'Asignación eliminada correctamente';
            } else {
                $this->message = 'No existe la asignación';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }
}
