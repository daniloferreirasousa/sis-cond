<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\UnitVehicle;
use App\Models\UnitPet;

class UnitController extends Controller
{
    public function getInfo($id): array
    {
        $array = ['error' => ''];

        $unit = Unit::find($id);
        if($unit) {
            $peoples = UnitPeople::where('id_unit', $id)->get();
            $vehicles = UnitVehicle::where('id_unit', $id)->get();
            $pets = UnitPet::where('id_unit', $id)->get();

            foreach($peoples as $pKey => $pValue) {
                $peoples[$pKey]['birthdate'] = date('d/m/Y', strtotime($pValue['birthdate']));
            }

            $array['peoples'] = $peoples;
            $array['vehicles'] = $vehicles;
            $array['pets'] = $pets;
        } else {
            $array['error'] = 'Unidade inexistente.';
            return $array;
        }

        return $array;
    }

    
    public function addPerson($id, Request $r): array
    {
        $array = ['error' => ''];
        
        $validator = Validator::make($r->all(), [
            'name'      => 'required',
            'birthdate' => 'required|date'
        ]);

        if(!$validator->fails()) {
            
            $name      = $r->input('name');
            $birthdate = $r->input('birthdate');

            $newPerson = new UnitPeople();
            $newPerson->id_unit   = $id;
            $newPerson->name      = $name;
            $newPerson->birthdate = $birthdate;
            $newPerson->save();

            $array['success'] = 'Morador adicionado com sucesso.';

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function addVehicle($id, Request $r): array
    {
        $array = ['error' => ''];

        $validator = validator::make($r->all(), [
            'title' => 'required',
            'color' => 'required',
            'plate' => 'required'
        ]);

        if(!$validator->fails()) {

            $title = $r->input('title');
            $color = $r->input('color');
            $plate = $r->input('plate');

            $newVehicle = new UnitVehicle();
            $newVehicle->id_unit = $id;
            $newVehicle->title = $title;
            $newVehicle->color = $color;
            $newVehicle->plate = $plate;
            $newVehicle->save();

            $array['success'] = 'Veículo adicionado com sucesso.';

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function addPet($id, Request $r): array
    {
        $array = ['error' => ''];

        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'race' => 'required'
        ]);

        if(!$validator->fails()) {
            $name = $r->input('name');
            $race = $r->input('race');

            $newPet = new UnitPet();
            $newPet->id_unit = $id;
            $newPet->name = $name;
            $newPet->race = $race;
            $newPet->save();

            $array['success'] = 'Pet adicionado com sucesso.';

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function removePerson($id, Request $r): array
    {
        $array = ['error' => ''];
     
        $validator = Validator::make($r->all(), [
            'id_person' => 'required'
        ]);
        
        if(!$validator->fails()) {
            $idPerson = $r->input('id_person');

            UnitPeople::where('id', $idPerson)
                ->where('id_unit', $id)
                ->delete();
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function removeVehicle($id, Request $r): array
    {
        $array = ['error' => ''];
     
        $validator = Validator::make($r->all(), [
            'id' => 'required'
        ]);
        
        if(!$validator->fails()) {
            $idItem = $r->input('id');

            UnitVehicle::where('id', $idItem)
                ->where('id_unit', $id)
                ->delete();
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function removePet($id, Request $r): array
    {
        $array = ['error' => ''];
     
        $validator = Validator::make($r->all(), [
            'id' => 'required'
        ]);
        
        if(!$validator->fails()) {
            $idItem = $r->input('id');

            UnitPet::where('id', $idItem)
                ->where('id_unit', $id)
                ->delete();
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }
}
