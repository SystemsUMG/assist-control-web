<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = Teacher::with('teacher_courses_assigned')->get();
            $this->result = true;
            $this->message = 'Profesores consultados correctamente';
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
            'name'      => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'active'    => ['required', 'string'],
            'email'     => ['required', 'email', 'unique:teachers,email'],
            'address'   => ['string', 'required'],
            'phone'     => ['required', 'integer'],
        ]);
        try {
            if ($request->password) {
                $validate['password'] = Hash::make($request->password);
                $teacher = Teacher::create($validate);
                if ($teacher) {
                    $this->result = true;
                    $this->message = 'Profesor registrado correctamente';
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
            $teacher = Teacher::with('teacher_courses_assigned')->find($id);
            if ($teacher) {
                $this->records = $teacher;
                $this->result = true;
                $this->message = 'Profesor consultado correctamente';
            } else {
                $this->message = 'No existe el profesor';
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
        $teacher = Teacher::find($id);
        if ($teacher) {
            $validate = $request->validate([
                'name'      => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'active'    => ['required', 'boolean'],
                'email'     => ['required', 'email', Rule::unique('teachers', 'email')->ignore($teacher), 'email'],
                'address'   => ['string', 'required'],
                'phone'     => ['required', 'integer'],
            ]);
            if ($request->password) {
                $validate['password'] = Hash::make($request->password);
            }
            $teacher->update($validate);
            $this->result = true;
            $this->message = 'Profesor actualizado correctamente';
        } else {
            $this->message = 'No existe el profesor';
        }
        $this->statusCode = 200;
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $teacher = Teacher::find($id);
            if ($teacher) {
                $teacher->delete();
                $this->result = true;
                $this->message = 'Profesor eliminado correctamente';
            } else {
                $this->message = 'No existe el profesor';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }
}
