<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    public function getInfo(): array 
    {
        $array = ['error' => '', 'list' => []];

        $userAuth = auth()->user();

        $userDetails = User::where('id', $userAuth['id'])->get();

        if($userDetails) {

            foreach($userDetails as $user) {
                $array['list'][] = [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'cpf' => $user['cpf']
                ];
            }

        } else {
            $array['error'] = 'Erro';
            return $array;
        }

        return $array;
    }

    public function update($id, Request $r): array
    {
        $array = ['error' => ''];

        $user = User::find($id);
        
        if($user) {    
            $validator = Validator::make($r->all(), [
                'name' => 'required',
                'email' => 'required',
                'cpf' => 'required'
            ]);

            if(!$validator->fails()) {
                $name = $r->input('name');
                $email = $r->input('email');
                $cpf = $r->input('cpf');

                $user->name = $name;
                $user->email = $email;
                if($user->cpf != $cpf) {
                    $hasCpf = User::where('id','!=', $user['id'])
                        ->where('cpf', $cpf)
                        ->count();
                    
                    if($hasCpf === 0) {
                        $user->cpf = $cpf;
                    }
                }
                $user->save();

                $array['success'] = 'Usuário alterado com sucesso';

            } else {
                $array['error'] = $validator->errors()->first();
                return $array;
            }
        
        } else {
            $array['error'] = 'Usuário não encontrado';
            return $array;
        }

        return $array;
    }
}
