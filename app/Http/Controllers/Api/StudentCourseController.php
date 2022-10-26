<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\StudentCourseAssigned;
use Exception;
use Illuminate\Http\Request;

class StudentCourseController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->records = StudentCourseAssigned::with([
                'student',
                'teacher_courses_assigned'  => function ($query) {
                    $query->with([
                        'career_assigned' => function ($query) {
                            $query->with(['center', 'career']);
                        },
                        'students_assigned',
                        'teacher',
                        'section',
                        'schedule',
                        'course',
                        'semester',
                    ]);
                },
                'attendances'])->get();
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
            'student_id'                    => ['required', 'integer', 'exists:students,id'],
            'teacher_course_assigned_id'    => ['required', 'integer', 'exists:teacher_course_assigneds,id'],
        ]);
        try {
            $student_course = StudentCourseAssigned::create($validate);
            if ($student_course) {
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
            $student_course = StudentCourseAssigned::with([
                'student',
                'teacher_courses_assigned'  => function ($query) {
                    $query->with([
                        'career_assigned' => function ($query) {
                            $query->with(['center', 'career']);
                        },
                        'students_assigned',
                        'teacher',
                        'section',
                        'schedule',
                        'course',
                        'semester',
                    ]);
                },
                'attendances'])->find($id);;
            if ($student_course) {
                $this->records = $student_course;
                $this->result = true;
                $this->message = 'Asignación consultada exitosamente';
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
            'student_id'                    => ['required', 'integer', 'exists:students,id'],
            'teacher_course_assigned_id'    => ['required', 'integer', 'exists:teacher_course_assigneds,id'],
        ]);
        try {
            $student_course = StudentCourseAssigned::find($id);
            if ($student_course) {
                $student_course->update($validate);
                $this->result = true;
                $this->message = 'Asignación actualizada';
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
            $student_course = StudentCourseAssigned::find($id);
            if ($student_course) {
                $student_course->delete();
                $this->result = true;
                $this->message = 'Asignación eliminada';
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

    /**
     * Display a listing of the resource.
     * @param  int  $id_student
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentCourses($student_id)
    {
        try {
            $student_course_assigneds = StudentCourseAssigned::where('student_id', $student_id)->get();
            $courses_assigneds = [];
            //Mapeo de datos para response records
            foreach ($student_course_assigneds as $record) {
                $student_course = collect();
                $item = $record->teacher_courses_assigned;
                $schedule = New ScheduleController(); //Instanciar para formatear hora

                $student_course->put('id',              $record->id);
                $student_course->put('student_id',      $record->student_id);
                $student_course->put('tc_assigned_id',  $record->teacher_course_assigned_id);
                $student_course->put('teacher',         $item->teacher->name." ".$item->teacher->last_name);
                $student_course->put('schedule',        $schedule->formatTime($item->schedule->begin_hour)." - ".$schedule->formatTime($item->schedule->end_hour));
                $student_course->put('course',          $item->course->name." - ".$item->section->letter);

                array_push($courses_assigneds, $student_course);
            }

            $this->records = $courses_assigneds;
            $this->result = true;
            $this->message = 'Datos consultados correctamente';
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }
}
