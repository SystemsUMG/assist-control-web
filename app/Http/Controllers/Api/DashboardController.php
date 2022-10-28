<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Career;
use App\Models\Course;
use App\Models\StudentAttendanceData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends ResponseController
{
    public function index (Request $request) {
        $careers = Career::all();

        $array_countries = [];
        $array_users  = [];
        foreach ($careers as $career) {
            $array_countries[] = $career->name;
            $array_users [] = Career::count();
        }
        $this->records['countries'] = $array_countries;
        $this->records['users_real'] = $array_users;
        $this->records['totals'] = [
            'total_users' => Career::count(),
            'total_countries' => Career::count(),
            'total_regions' => Career::count(),
            'total_departments' => Career::count(),
            'total_rols' => Career::count(),
        ];

        $this->result = true;
        $this->statusCode = 200;
        $this->message = "Registros consultados exitosamente.";

        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function reportStudent($student_id) {
        try {
            $array_date = [];
            $array_attendances  = [];
            $attendances = StudentAttendanceData::whereRelation('student_course_assigned', 'student_id', $student_id)->get();
            $dates = $attendances->unique('created_at');
            foreach ($dates as $date) {
                $array_date[] = Carbon::parse( $date->created_at)->format('d/m/Y');
                $array_attendances[] = $attendances->where('created_at', $date->created_at)->count();
            }
            $this->records['dates'] = $array_date;
            $this->records['attendances'] = $array_attendances;
            $this->result = true;
            $this->statusCode = 200;
            $this->message = "Registros consultados exitosamente.";
        } catch(\Exception $exception) {
            $this->message = $exception->getMessage();
        }
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}
