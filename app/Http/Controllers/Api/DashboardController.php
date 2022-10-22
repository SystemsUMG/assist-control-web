<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Models\Career;
use App\Models\Course;
use Illuminate\Http\Request;

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
}
