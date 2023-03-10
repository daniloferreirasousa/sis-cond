<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\FoundAndLost;

class FoundAndLostController extends Controller
{
    public function getAll(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }

    public function insert(): array
    {
        $array = ['error' => ''];

        return $array;
    }

    public function update(): array
    {
        $array = ['error' => ''];

=======
        $lost = FoundAndLost::where('status', 'LOST')
            ->orderBy('date_created', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $recovered = FoundAndLost::where('status', 'RECOVERED')
            ->orderBy('date_created', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        foreach($lost as $lostKey => $lostValue) {
            $lost[$lostKey]['date_created'] = date('d/m/Y', strtotime($lostValue['date_created']));
            $lost[$lostKey]['photo']        = asset('storage/'.$lostValue['photo']);
        }   

        foreach($recovered as $recKey => $recValue) {
            $recovered[$recKey]['date_created'] = date('d/m/Y', strtotime($recValue['date_created']));
            $recovered[$recKey]['photo']        = asset('storage/'.$recValue['photo']);
        }
        $array['lost']      = $lost;
        $array['recovered'] = $recovered;
        return $array;
    }

    public function insert(Request $r): array
    {
        $array = ['error' => ''];

        $validator = Validator::make($r->all(), [
            'description' => 'required',
            'where'       => 'required',
            'photo'       => 'required|file|mimes:jpg,png'
        ]);
        if(!$validator->fails()) {

            $description = $r->input('description');
            $where = $r->input('where');
            $file  = $r->file('photo')->store('public');
            $file  = explode('public/', $file);
            $photo = $file[1];

            $newLost = new FoundAndLost();
            $newLost->status       = 'LOST';
            $newLost->photo        = $photo;
            $newLost->description  = $description;
            $newLost->where        = $where;
            $newLost->date_created = date('Y-m-d');
            $newLost->save();

            $array['success'] = 'Cadastrado realizado com sucesso.';

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }
        
        return $array;
    }

    public function update($id, Request $r): array
    {
        $array = ['error' => ''];

        $status = $r->input('status');

        if($status && in_array($status, ['lost', 'recovered'])) {
            $item = FoundAndLost::find($id);
            if($item) { 
                $item->status = strtoupper($status);
                $item->save();
            } else {
                $array['error'] = 'Item não encontrado.';
                return $array;
            }
        } else {
            $array['error'] = 'Status não permitido.';
            return $array;
        }
        
>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
        return $array;
    }
}
