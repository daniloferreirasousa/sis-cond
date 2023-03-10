<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\UnitVehicle;
use App\Models\UnitPet;

class UnitController extends Controller
{
<<<<<<< HEAD
    public function getInfo(): array
    {
        $array = ['error' => ''];

        return $array;
    }
=======
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

>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    
    public function addPerson(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }
=======

        return $array;
    }

>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    
    public function addVehicle(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }
=======

        return $array;
    }

>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    
    public function addPet(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }
=======

        return $array;
    }

>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    
    public function removePerson(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }

=======

        return $array;
    }

    
>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    public function removeVehicle(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
        return $array;
    }

=======

        return $array;
    }

    
>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
    public function removePet(): array
    {
        $array = ['error' => ''];

<<<<<<< HEAD
=======

>>>>>>> 9b7245c3015a7fe3502b9870cadfe8627d877d83
        return $array;
    }
}
