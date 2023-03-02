<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            'name'     => 'APT 100',
            'id_owner' => '1'
        ]);
        DB::table('units')->insert([
            'name'     => 'APT 101',
            'id_owner' => '1'
        ]);
        DB::table('units')->insert([
            'name'     => 'APT 102',
            'id_owner' => '0'
        ]);
        DB::table('units')->insert([
            'name'     => 'APT 103',
            'id_owner' => '0'
        ]);
        DB::table('units')->insert([
            'name'     => 'APT 104',
            'id_owner' => '1'
        ]);
        DB::table('areas')->insert([
            'allowed'    => '1',
            'title'      => 'Academia',
            'cover'      => 'gym.jpg',
            'days'       => '1,2,3,4,5',
            'start_time' => '06:00:00',
            'end_time'   => '22:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed'    => '1',
            'title'      => 'Piscina',
            'cover'      => 'pool.jpg',
            'days'       => '1,2,3,4,5',
            'start_time' => '07:00:00',
            'end_time'   => '23:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed'    => '1',
            'title'      => 'Churrasqueira',
            'cover'      => 'barbecue.jpg',
            'days'       => '4,5,6',
            'start_time' => '09:00:00',
            'end_time'   => '23:00:00'
        ]);

        DB::table('walls')->insert([
            'title' => 'Título de Aviso de Teste',
            'body' => 'Lorem ipsum dolor asit mneun',
            'date_created' => '2023-03-02 15:00:00'
        ]);

        DB::table('walls')->insert([
            'title' => 'Aviso Geral para todos',
            'body' => 'Lorem ipsum dolor asit mneun',
            'date_created' => '2023-03-02 15:40:00'
        ]);
    }
}
