<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;

class ReservationController extends Controller
{
    
    public function getReservations(): array
    {
        $array = ['error' => '', 'list' => []];
        $daysHelper = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        $areas = Area::where('allowed', 1)->get();

        foreach($areas as $area) {
            $dayList = explode(',', $area['days']);

            $dayGroups = [];

            // Adicionando o primeiro dia
            $lastDay = intval(current($dayList));
            $dayGroups[] = $daysHelper[$lastDay];
            array_shift($dayList);

            // Adicionando dias relevantes
            foreach($dayList as $day) {
                if(intval($day) != $lastDay+1) {
                    $dayGroups[] = $daysHelper[$lastDay];
                    $dayGroups[] = $daysHelper[$day];
                }
                $lastDay = intval($day);
            }

            // Adicionando o ultimo dia
            $dayGroups[] = $daysHelper[end($dayList)];

            // Juntando as datas (Dia1-Dia2)
            $dates = '';
            $close = 0;
            foreach($dayGroups as $group) {
                if($close === 0) {
                    $dates .= $group;
                } else {
                    $dates .= '-'.$group.',';
                }

                $close = 1 - $close;
            }
            $dates = explode(',', $dates);
            array_pop($dates);

            // Adicionando o TIME
            $start = date('H:i', strtotime($area['start_time']));
            $end   = date('H:i', strtotime($area['end_time']));

            foreach($dates as $dKey => $dValue) {
                $dates[$dKey] .= ' '.$start.' às '.$end; 
            }

            $array['list'][] = [
                'id' => $area['id'],
                'cover' => asset('storage/'.$area['cover']),
                'title' => $area['title'],
                'dates' => $dates
            ];
        }


        $array['list'] = $areas;

        return $array;
    }

    
    public function setReservation(): array
    {
        $array = ['error' => ''];

        return $array;
    }

    
    public function getDisabledDates(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function getTimes(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function getMyReservations(): array
    {
        $array = ['error' => ''];


        return $array;
    }

    
    public function delMyReservation(): array
    {
        $array = ['error' => ''];

        return $array;
    }
}
