<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Billet;
use App\Models\Unit;

class BilletController extends Controller
{
    public function getAll(Request $r): array
    {
        $array = ['error' => ''];

        $property = $r->input('property');

        if($property) {
            $user = auth()->user();

            $unit = Unit::where('id', $property)
                ->where('id_owner', $user['id'])
                ->count();
            
            if($unit > 0) {
                $billets = Billet::where('id_unit', $r->input('property'))->get();

                foreach($billets as $billetKey => $billetValue) {
                    $billets[$billetKey]['file_url'] = asset('storage/'.$billetValue['file_url']);
                }
                
                if($billets->count() == 0) {
                    $array['error'] = "Nenhum boleto encontrado para essa unidade.";
                }

                $array['list'] = $billets;
            } else {
                $array['error'] = 'Essa unidade não pertence a você.';
            }

        } else {
            $array['error'] = 'A propriedade é necessária.';
        }

        return $array;
    }
}
