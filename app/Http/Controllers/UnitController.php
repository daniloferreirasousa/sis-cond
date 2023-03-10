<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    
    public function addPerson(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function addVehicle(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function addPet(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function removePerson(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function removeVehicle(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function removePet(): array
    {
        $array = ['error' => ''];


        return $array;
    }
}
