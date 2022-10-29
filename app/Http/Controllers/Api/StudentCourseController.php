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
            //'student_id'                    => ['required', 'integer', 'exists:students,id'],
            'teacher_course_assigned_id'    => ['required', 'integer', 'exists:teacher_course_assigneds,id'],
        ]);
        try {
            if(!empty($request->students_assigned)) {
                $students = explode(',', $request->students_assigned);
                foreach ($students as $student) {
                    StudentCourseAssigned::create([
                        'student_id' => $student,
                        'teacher_course_assigned_id' => $request->teacher_course_assigned_id
                    ]);
                }
            }
            $this->result = true;
            $this->message = 'Asignación creada correctamente';
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
    public function update($id, Request $request)
    {
        try {
            $teacher_course = $request->teacher_course_assigned_id;
            $students_assigned = $request->students_assigned;
            $students_courses = StudentCourseAssigned::where('teacher_course_assigned_id', $teacher_course)->get();

            //Vacio (se eliminan todos)
            if(empty($students_assigned)) {
                //Eliminar todos los registros
                foreach($students_courses as $student_course) {
                    $student_course_assigned = StudentCourseAssigned::where([
                        'teacher_course_assigned_id' => $teacher_course, 
                        'student_id' => $student_course->student_id
                    ])->first();
                    if ($student_course_assigned) {
                        $student_course_assigned->delete();
                    }
                }
            } else { //No vacio se deben eliminar los que no vengan y agregar los nuevos
                $students_assigneds = explode(',', $request->students_assigned);
                $olds = [];
                $news = [];
                //Obtener ids de carreras nuevos
                foreach($students_assigneds as $student_assigned) {
                    if (!in_array($student_assigned, $students_courses->pluck('student_id')->toArray())) {
                        array_push($news, $student_assigned);
                    }
                }
                //Obtener ids a eliminar (los que no vienen en request)
                foreach($students_courses as $student_course) {
                    if (!in_array($student_course->student_id, $students_assigneds)) {
                        array_push($olds, $student_course->student_id);
                    }
                }
                //Borrar registros 
                if (!empty($olds)) {
                    foreach ($olds as $old) {
                        $student_course_assigned = StudentCourseAssigned::where([
                            'teacher_course_assigned_id' => $teacher_course, 
                            'student_id' => $old
                        ])->first();
                        if ($student_course_assigned) {
                            $student_course_assigned->delete();
                        }
                    }
                }
                //Crear registros
                if (!empty($news)) {
                    foreach ($news as $new) {
                        StudentCourseAssigned::create([
                            'student_id' => $new,
                            'teacher_course_assigned_id' => $teacher_course
                        ]);
                    }
                }
            }

            $this->records = $students_courses;
            $this->result = true;
            $this->message = 'Datos actualizados correctamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        }
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

                $courses_assigneds[] = $student_course;
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

    public function percentage($student_id) {
        try {
            $student_course_assigneds = StudentCourseAssigned::where('student_id', $student_id)->get();
            $this->records = [];
            foreach ($student_course_assigneds as $course) {
                $percentage = $this->division(100, $course->teacher_courses_assigned->total_assists) * $course->attendances->count();
                $this->records[] = [
                    'course' => $course->teacher_courses_assigned->course->name,
                    'percentage' => round($percentage).'%',
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

    public function division($number_1, $number_2) {
        return $number_2 != 0 ? $number_1 / $number_2 : 0;
    }

}
