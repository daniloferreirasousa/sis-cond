<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Reservation;
use App\Models\Area;
use App\Models\AreaDisabledDay;
use App\Models\Unit;

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

        return $array;
    }

    
    public function setReservation($id, Request $r): array
    {
        $array = ['error' => ''];

        $validator = Validator::make($r->all(), [
            'date'     => 'required|date_format:Y-m-d',
            'time'     => 'required|date_format:H:i:s',
            'property' => 'required'
        ]);

        if(!$validator->fails()) {
            $date     = $r->input('date');
            $time     = $r->input('time');
            $property = $r->input('property');

            $unit = Unit::find($property);
            $area = Area::find($id);

            if($unit && $area) {
                $can = true;
                
                $weekday = date('w', strtotime($date));
                
                // Veririficar se está dentro da Disponibilidade padrão
                $allowedDays = explode(',', $area['days']);
                if(!in_array($weekday, $allowedDays)) {
                    $can = false;
                } else {
                    $start = strtotime($area['start_time']);
                    $end = strtotime('-1 hour', strtotime($area['end_time']));
                    $revtime = strtotime($time);

                    if($revtime < $start || $revtime > $end) {
                        $can = false;
                    } else {

                    }
                }
                
                // Verificar se está fora dos DisabledDays
                $existingDisabledDay = AreaDisabledDay::where('id_area', $id)
                    ->where('day', $date)
                    ->count();
                if($existingDisabledDay > 0) {
                    $can = false;
                }

                // Verificar se não tem nenhuma reserva para o dia/horário
                $existingReservation = Reservation::where('id_area', $id)
                    ->where('reservation_date', $date.' '.$time)
                    ->count();
                if($existingReservation > 0) {
                    $can = false;
                }


                if($can) {
                    $newReservation = new Reservation();
                    $newReservation->id_unit = $property;
                    $newReservation->id_area = $id;
                    $newReservation->reservation_date = $date.' '.$time;
                    $newReservation->save();

                    $array['success'] = 'Reserva feita com sucesso.';

                } else {
                    $array['error'] = 'Reservar não permitida nesse dia/horário.';
                    return $array;
                }
            } else {
                $array['error'] = 'Dados incorretos';
                return $array;
            }

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }


        return $array;
    }

    
    public function getDisabledDates($id): array
    {
        $array = ['error' => '', 'list' => []];
        $area = Area::find($id);

        if($area) {
            // Dias disabled padrão
            $disabledDays = AreaDisabledDay::where('id_area', $id)->get();
            foreach($disabledDays as $disabledDay) {
                $array['list'][] = $disabledDay['day'];
            }

            // Dias disabled através do allowed
            $allowedDays = explode(',', $area['days']);
            $offDays = [];

            for($q=0;$q<7;$q++) {
                if(!in_array($q, $allowedDays)) {
                    $offDays[] = $q;
                }
            }

            // Listar os dias proíbidos 3 meses para frente
            $start = time();
            $end = strtotime('+3 months');

            for(
                $current = $start;
                $current < $end;
                $current = strtotime('+1 day', $current)
            ) {
                $wd = date('w', $current);
                if(in_array($wd, $offDays)) {
                    $array['list'][] = date('Y-m-d', $current);
                }
            }



        } else {
            $array['error'] = 'Area inexistente';
            return $array;
        }

        return $array;
    }

    
    public function getTimes($id, Request $r): array
    {
        $array = ['error' => '', 'list' => []];

        $validator = Validator::make($r->all(), [
            'date' => 'required|date_format:Y-m-d'
        ]);

        if(!$validator->fails()) {
            $date = $r->input('date');
            $area = Area::find($id);

            if($area) {
                $can = true;
                // Verificar se é dia desabilitado
                $existingDisabledDay = AreaDisabledDay::where('id_area', $id)
                    ->where('day', $date)
                    ->count();
                if($existingDisabledDay > 0) {
                    $can = false;
                }

                // Verificar se é dia permitido
                $allowedDays = explode(',', $area['days']);
                $weekday = date('w', strtotime($date));
                if(!in_array($weekday, $allowedDays)) {
                    $can = false;
                }

                if($can) {
                    $start = strtotime($area['start_time']);
                    $end = strtotime($area['end_time']);
                    $times = [];

                    for(
                        $lastTime = $start;
                        $lastTime < $end;
                        $lastTime = strtotime('+1 hour', $lastTime)
                    ) {
                        $times[] = $lastTime;
                    }

                    $timeList = [];
                    foreach($times as $time) {
                        $timeList[] = [
                            'id' => date("H:i:s", $time),
                            'title' => date("H:i", strtotime($time)).' - '.date("H:i", strtotime("+1 hour", $time))
                        ];
                    }

                    // Removendo as reservas
                    $reservations = Reservation::where('id_area', $id)
                        ->whereBetween('reservation_date', [
                            $date.' 00:00:00',
                            $date.' 23:59:59'
                        ])
                        ->get();
                    $toRemove = [];

                    foreach($reservations as $reservation) {
                        $time = date("H:i:s", strtotime($reservation['reservation_date']));
                        $toRemove[] = $time;
                    }

                    foreach($timeList as $timeItem) {
                        if(!in_array($timeItem['id'], $toRemove)) {
                            $array['list'][] = $timeItem;
                        }
                    }
                }
            } else {
                $array['error'] = 'Area inexistente';
                return $array;
            }

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    
    public function getMyReservations(Request $r): array
    {
        $array = ['error' => '', 'list' => []];
        
        $validator = Validator::make($r->all(), [
            'property' => 'required'
        ]);

        if(!$validator->fails()) {
            $property = $r->input('property');

            $unit = Unit::find($property);
            if($unit) {
                
                $reservations = Reservation::where('id_unit', $property)
                    ->orderBy('reservation_date', 'DESC')
                    ->get();
                 
                foreach($reservations as $reservation) {
                    $area = Area::find($reservation['id_area']);

                    $daterev   = date('d/m/Y H:i', strtotime($reservation['reservation_date']));
                    $aftertime = date('H:i', strtotime('+1 hour', strtotime($reservation['reservation_date'])));
                
                    $daterev .= ' à '.$aftertime;

                    $array['list'][] = [
                        'id'           => $reservation['id'],
                        'id_area'      => $reservation['id_area'],
                        'title'        => $area['title'],
                        'cover'        =>  asset('storage/'.$area['cover']),
                        'datereserved' => $daterev
                    ];
                }

            } else {
                $array['error'] = 'Propriedade inexistente';
                return $array;
            }
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }


        return $array;
    }

    
    public function delMyReservation($id): array
    {
        $array = ['error' => ''];
        
        $user = auth()->user();
        $reservation = Reservation::find($id);

        if($reservation) {

            $unit = Unit::where('id', $reservation['id_unit'])
                ->where('id_owner', $user['id'])
                ->count();

            if($unit > 0) {
                Reservation::find($id)->delete();
                $array['success'] = 'Reserva excluida com sucesso';
            } else {
                $array['error'] = 'Essa reserva não é sua';
                return $array;
            }
        } else {
            $array['error'] = 'Reserva inexistente';
            return $array;
        }
        return $array;
    }
}
