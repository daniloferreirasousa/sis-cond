<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Unit;

class AuthController extends Controller
{
    public function unauthorized()
    {
        return response()->json([
            'error' => 'Não autorizado'
        ], 401);
    }

    
    public function register(Request $r): array
    {
        // Array de retorno para o usuário
        $array = ['error' => ''];

        // Validação dos dados enviados pelo usuário
        $validator = Validator::make($r->all(), [
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'cpf'               => 'required|digits:11|unique:users,cpf',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password'
        ]);

        // Criação de um novo usuário
        if(!$validator->fails()) {
            $name     = $r->input('name');
            $email    = $r->input('email');
            $cpf      = $r->input('cpf');
            $password = $r->input('password');

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->cpf = $cpf;
            $newUser->password = $hash;
            $newUser->save();

            $token = auth()->attempt([
                'cpf' => $cpf,
                'password' => $password
            ]);

            // Verificação de login do usuário, após ser cadastrado
            if(!$token) {
                $array['error'] = 'Ocorreu um erro.';
                return $array;
            }

            // Retorno dos dados do usuário, após ter feito login
            $array['token'] = $token;
            $user = auth()->user();
            $array['user'] = $user;

            $properties = Unit::select(['id', 'name'])
                ->where('id_owner', $user['id'])
                ->get();

            $array['user']['properties'] = $properties;


        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }


    public function login(Request $r): array
    {
        $array = ['error' => ''];

        $validator = Validator::make($r->all(), [
            'cpf'      => 'required|digits:11',
            'password' => 'required'
        ]);

        if(!$validator->fails()) {
            $cpf      = $r->input('cpf');
            $password = $r->input('password');

            $token = auth()->attempt([
                'cpf' => $cpf,
                'password' => $password
            ]);

            // Verificação de login do usuário
            if(!$token) {
                $array['error'] = 'CPF e/ou Senha estão incorretos.';
                return $array;
            }

            // Retorno dos dados do usuário, após ter feito login
            $array['token'] = $token;
            $user = auth()->user();
            $array['user'] = $user;

            $properties = Unit::select(['id', 'name'])
                ->where('id_owner', $user['id'])
                ->get();

            $array['user']['properties'] = $properties;


        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }



    public function validateToken(): array
    {
        $array = ['error' => ''];

        // Retorno dos dados do usuário, após ter feito login
        $user = auth()->user();
        $array['user'] = $user;

        $properties = Unit::select(['id', 'name'])
            ->where('id_owner', $user['id'])
            ->get();

        $array['user']['properties'] = $properties;

        return $array;
    }

    public function logout(): array
    {
        $array = ['error' => ''];
        auth()->logout();
        return $array;
    }
}
