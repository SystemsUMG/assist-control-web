<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = Student::with('career_assigned')->get();
            $this->result = true;
            $this->message = 'Estudiantes consultados correctamente';
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
            'name'              => ['required', 'string'],
            'last_name'         => ['required', 'string'],
            'email'             => ['required', 'email', 'unique:students,email'],
            'begin_date'        => ['required', 'string'],
            'end_date'          => ['string', 'nullable'],
            'age'               => ['required', 'integer'],
            'dpi'               => ['required', 'numeric'],
            'carnet'            => ['required', 'string'],
            'career_assigned_id' => ['required', 'integer', 'exists:career_assigneds,id'],
        ]);
        try {
            if ($request->password) {
                $validate['password'] = Hash::make($request->password);
                $student = Student::create($validate);
                if ($student) {
                    $this->result = true;
                    $this->message = 'Estudiante registrado correctamente';
                }
            } else {
                $this->message = 'La contraseña es obligatoria';
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
            $student = Student::find($id);
            if ($student) {
                $this->records = $student;
                $this->result = true;
                $this->message = 'Estudiante consultado correctamente';
            } else {
                $this->message = 'No existe el estudiante';
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
        $student = Student::find($id);
        if ($student) {
            $validate = $request->validate([
                'name'              => ['required', 'string'],
                'last_name'         => ['required', 'string'],
                'email'             => ['required', 'email', Rule::unique('students', 'email')->ignore($student), 'email'],
                'begin_date'        => ['required', 'string'],
                'end_date'          => ['string', 'nullable'],
                'age'               => ['required', 'integer'],
                'dpi'               => ['required', 'numeric'],
                'carnet'            => ['required', 'string'],
                'career_assigned_id' => ['required', 'integer', 'exists:career_assigneds,id'],
            ]);
            if ($request->password) {
                $validate['password'] = Hash::make($request->password);
            }
            $student->update($validate);
            $this->result = true;
            $this->message = 'Estudiante actualizado correctamente';
        } else {
        $this->message = 'No existe el estudiante';
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
            $student = Student::find($id);
            if ($student) {
                $student->delete();
                $this->result = true;
                $this->message = 'Estudiante eliminado correctamente';
            } else {
                $this->message = 'No existe el estudiante';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }
}
