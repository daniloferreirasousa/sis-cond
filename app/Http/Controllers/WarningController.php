<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Warning;
use App\Models\Unit;

class WarningController extends Controller
{
    public function getMyWarnings(Request $r): array
    {
        $array = ['error' => ''];
        
        $property = $r->input('property');

        if($property) {
            $user = auth()->user();
            $unit = Unit::where('id', $property)
                ->where('id_owner', $user['id'])
                ->count();

            if($unit > 0) {             
                $warnings = Warning::where('id_unit', $property)
                ->orderBy('date_created', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();

                foreach($warnings as $warningKey => $warningValue) {
                    $warnings[$warningKey]['date_created'] = date('d/m/Y', strtotime($warningValue['date_created']));

                    $photoList = [];
                    $photos = explode(',', $warningValue['photos']);
                    foreach($photos as $photo) {
                        if(!empty($photo)) {
                            $photoList[] = asset('storage/'.$photo);
                        }
                    }
                    $warnings[$warningKey]['photos'] = $photoList;
                }
                $array['list'] = $warnings;
            } else {
                $array['error'] = 'Essa unidade não é sua.';
            }
        } else {
            $array['error'] = 'A propriedade é necessária.';
        }

        return $array;
    } // End getMyWarnings

    public function addWarningFile(Request $r): array
    {
        $array = ['error' => ''];
        
        $validator = Validator::make($r->all(), [
            'photo' => 'required|file|mimes:jpg,png'
        ]);

        if(!$validator->fails()) {
            $file = $r->file('photo')->store('public');

            $array['photo'] = asset(Storage::url($file));
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    } // End addWarningFile


    public function setWarning(Request $r): array
    {
        $array = ['error' => ''];
        

        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'property' => 'required'
        ]);
        if(!$validator->fails()) {

            $title = $r->input('title');
            $property = $r->input('property');
            $list = $r->input('list');

            $newWarn = new Warning();
            $newWarn->title = $title;
            $newWarn->id_unit = $property;
            $newWarn->status = 'IN_REVIEW'; // Valor padrão
            $newWarn->date_created = date('Y-m-d');

            if($list && is_array($list)) {
                $photos = [];
                foreach($list as $listItem) {
                    $url = explode(',', $listItem);
                    $photos = end($url);
                }
                $newWarn->photos = implode(',', $photos);
            } else {
                $newWarn->photos = '';
            }
            $newWarn->save();
            $array['error'] = 'Ocorrência criada com sucesso.';
        } else {
            $array['error'] = $validator->errors()->first();
        }
        return $array;
    } // End setWarning
}
