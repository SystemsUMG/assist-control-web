<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response\ResponseController;
use App\Http\Requests\AuthLoginRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ResponseController
{

    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->validated();
        //Autenticar con ambos modelos
        if (!auth()->attempt($credentials) && !auth('api')->attempt($credentials)) {
            $this->message = 'Credenciales incorrectas';
            $this->statusCode = 401;
            $this->result = false;
        } else {
            $student = Student::firstWhere('email', $request->email);
            $teacher = Teacher::firstWhere('email', $request->email);
            //Validar student o teacher
            $user = $student ?? $teacher;
            $type = $student ? 'student' : 'teacher';
            $token = $user->createToken('auth-token');

            $this->statusCode = 200;
            $this->result = true;
            $this->message = 'Bienvenido(a)';
            $this->records = [
                'user_id' => $user->id,
                'name'    => $user->name,
                'type'    => $type,
                'token'   => $token->plainTextToken,
            ];
        }

        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        $this->statusCode = 200;
        $this->result = true;
        $this->message = 'Se ha cerrado la sesión';
        return $this->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}
