<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\StudentAttendanceData;
use App\Models\StudentCourseAssigned;
use App\Models\TeacherCourseAssigned;
use Illuminate\Http\Request;

class AttendaceController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'student_course_assigned_id' => ['required', 'exists:student_course_assigneds,id'],
                'observations' => ['nullable', 'string']
            ]);
            $data_attendance = StudentCourseAssigned::find($request->student_course_assigned_id);
            $begin_hour = $data_attendance->teacher_courses_assigned->schedule->begin_hour;
            $end_hour = $data_attendance->teacher_courses_assigned->schedule->end_hour;
            $hour_registered = date('H:i:s');
            $this->message = 'No estás en horario de curso';
            if ($hour_registered >= $begin_hour  && $hour_registered <= $end_hour) {
                $attendance_today = StudentAttendanceData::where('student_course_assigned_id', $request->student_course_assigned_id)
                    ->whereBetween('schedule_register', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
                if (!$attendance_today) {
                    $validate['schedule_register'] = date('Y-m-d H:i:s');
                    StudentAttendanceData::create($validate);
                    $this->message = 'Asistencia registrada';
                } else {
                    $this->message = 'Ya has registrado tu asistencia hoy';
                }
            }
            $this->result = true;
            $this->statusCode = 200;
            return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        } catch (\Exception $exception) {
            $this->statusCode = 400;
            return $this->jsonResponse($this->records, $this->result, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
