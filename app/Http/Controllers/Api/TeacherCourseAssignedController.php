<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\TeacherCourseAssigned;
use Exception;
use Illuminate\Http\Request;

class TeacherCourseAssignedController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = TeacherCourseAssigned::with([
                'career_assigned' => function ($query) {
                    $query->with(['center', 'career']);
                },
                'students_assigned',
                'teacher',
                'section',
                'schedule',
                'course',
                'semester',
            ])->get();
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
            'career_assigned_id'    => ['required', 'integer', 'exists:career_assigneds,id'],
            'teacher_id'            => ['required', 'integer', 'exists:teachers,id'],
            'course_id'             => ['required', 'integer', 'exists:courses,id'],
            'semester_id'           => ['required', 'integer', 'exists:semesters,id'],
            'section_id'            => ['required', 'integer', 'exists:sections,id'],
            'schedule_id'           => ['required', 'integer', 'exists:schedules,id'],
            'total_assists'         => ['required', 'integer'],
        ]);
        try {
            $assigneds = TeacherCourseAssigned::create($validate);
            if ($assigneds) {
                $this->result = true;
                $this->message = 'Asignación creada correctamente';
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
            $assigned = TeacherCourseAssigned::with([
                'career_assigned' => function ($query) {
                    $query->with(['center', 'career']);
                },
                'students_assigned',
                'teacher',
                'section',
                'schedule',
                'course',
                'semester',
            ])->find($id);
            if ($assigned) {
                $this->records = $assigned;
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
            'career_assigned_id'    => ['required', 'integer', 'exists:career_assigneds,id'],
            'teacher_id'            => ['required', 'integer', 'exists:teachers,id'],
            'course_id'             => ['required', 'integer', 'exists:courses,id'],
            'semester_id'           => ['required', 'integer', 'exists:semesters,id'],
            'section_id'            => ['required', 'integer', 'exists:sections,id'],
            'schedule_id'           => ['required', 'integer', 'exists:schedules,id'],
            'total_assists'         => ['required', 'integer'],
        ]);
        try {
            $assigned = TeacherCourseAssigned::find($id);
            if ($assigned) {
                $assigned->update($validate);
                $this->result = true;
                $this->message = 'Asignación actualizada exitosamente';
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
            $assigned = TeacherCourseAssigned::find($id);
            if ($assigned) {
                $assigned->delete();
                $this->result = true;
                $this->message = 'Asignación eliminado correctamente';
            } else {
                $this->message = 'No existe la asignación';
            }
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception) {
            $this->message = 'Error: otros datos dependen de este registro';
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }
}
