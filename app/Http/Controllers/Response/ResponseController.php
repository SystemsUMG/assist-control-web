<?php

namespace App\Http\Controllers\Response;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public $result;
    public $records;
    public $statusCode;
    public $message;

    public function __construct()
    {
        $this->result = false;
        $this->records = [];
        $this->statusCode = 400;
        $this->message = 'Ha ocurrido un error.';
    }

    public function jsonResponse($records, $result, $message, $statusCode)
    {
        $response = [
            'result' => $result,
            'records' => $records,
            'message' => $message,
        ];
        return response()->json($response, $statusCode);
    }
}