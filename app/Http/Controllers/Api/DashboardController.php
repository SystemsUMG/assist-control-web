<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Career;
use App\Models\Center;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentAttendanceData;
use App\Models\StudentCourseAssigned;
use App\Models\Teacher;
use App\Models\TeacherCourseAssigned;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends ResponseController
{
    public function totals() {

        $this->records = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'careers' => Career::count(),
            'centers' => Center::count(),
        ];
        $this->result = true;
        $this->statusCode = 200;
        $this->message = "Registros consultados exitosamente.";
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function reportStudent(Request $request) {
        try {
            $array_date = [];
            $array_attendances  = [];
            $attendances = StudentAttendanceData::whereRelation('student_course_assigned', 'student_id', $request->student_id)->get();
            $this->extracted($attendances, $array_date, $array_attendances);
            $this->result = true;
            $this->statusCode = 200;
            $this->message = "Registros consultados exitosamente.";
        } catch(Exception $exception) {
            $this->message = $exception->getMessage();
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function reportSemester(Request $request) {
        try {
            $semester = $request->semester_id;
            $career = $request->career_id;
            $array_course = [];
            $array_attendances  = [];
            $teacher_courses = TeacherCourseAssigned::where('semester_id', $semester)
                ->whereRelation('career_assigned', 'career_id', $career)->get();
            foreach ($teacher_courses as $teacher_course) {
                $array_course[] = $teacher_course->course->name.' - '.$teacher_course->section->letter;
                $collect_attendance = [];
                foreach ($teacher_course->students_assigned as $student_assigned) {
                    $collect_attendance[] = collect($student_assigned->attendances)->count();
                }
                $array_attendances[] = collect($collect_attendance)->sum();
            }
            $this->records['courses'] = $array_course;
            $this->records['attendances'] = $array_attendances;
            $this->result = true;
            $this->statusCode = 200;
            $this->message = "Registros consultados exitosamente.";
        } catch(Exception $exception) {
            $this->message = $exception->getMessage();
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function reportCenter(Request $request) {
        try {
            $careers = Career::whereRelation('centers_assigned', 'center_id', $request->center_id)->get();
            $array_career = [];
            $array_attendances = [];
            foreach ($careers as $career) {
                $array_career[] = $career->name;
                $students_assigned = StudentCourseAssigned::whereHas('teacher_courses_assigned', function ($query) use ($career) {
                    $query->whereHas('career_assigned', function ($query) use ($career) {
                        $query->where('career_id', $career->id);
                    });
                })->get();
                $collect_attendance = [];
                foreach ($students_assigned as $student_assigned) {
                    $collect_attendance[] = collect($student_assigned->attendances)->count();
                }

                $array_attendances[] = collect($collect_attendance)->sum();
            }
            $this->records['careers'] = $array_career;
            $this->records['attendances'] = $array_attendances;
            $this->result = true;
            $this->statusCode = 200;
            $this->message = "Registros consultados exitosamente.";
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function reportSection(Request $request) {
        try {
            $request->validate([
                'begin_date' => ['required', 'date_format:Y-m-d'],
                'end_date' => ['required', 'date_format:Y-m-d'],
                'teacher_course_assigneds_id' => ['required', 'exists:teacher_course_assigneds,id'],
            ]);
            $array_date = [];
            $array_attendances  = [];
            $begin_date = $request->begin_date.' 00:00:00';
            $end_date = $request->end_date.' 23:59:59';
            $course = $request->teacher_course_assigneds_id;
            $attendances = StudentAttendanceData::whereBetween('schedule_register', [$begin_date, $end_date])
                ->whereRelation('student_course_assigned', 'teacher_course_assigned_id', $course)->get();
            $this->extracted($attendances, $array_date, $array_attendances);
            $this->result = true;
            $this->statusCode = 200;
            $this->message = "Registros consultados exitosamente.";
        } catch(Exception $exception) {
            $this->message = $exception->getMessage();
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * @param $attendances
     * @param array $array_date
     * @param array $array_attendances
     * @return void
     */
    public function extracted($attendances, array $array_date, array $array_attendances): void
    {
        $dates = $attendances->unique('created_at');
        foreach ($dates as $date) {
            $array_date[] = Carbon::parse($date->created_at)->format('d/m/Y');
            $array_attendances[] = $attendances->where('created_at', $date->created_at)->count();
        }
        $this->records['dates'] = $array_date;
        $this->records['attendances'] = $array_attendances;
    }
}
