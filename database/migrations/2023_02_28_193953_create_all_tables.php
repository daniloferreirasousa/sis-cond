<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('password');
        });

        Schema::create('units', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->integer('id_owner');
        });

        Schema::create('unitpeoples', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->string('name');
            $table->date('birthdate');
        });

        Schema::create('unitvehicles', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('color');
            $table->string('plate');
        });

        Schema::create('unitpets', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->string('name');
            $table->string('race');
        });

        Schema::create('walls', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('body');
            $table->datetime('date_created');
        });

        Schema::create('walllikes', function(Blueprint $table){
            $table->id();
            $table->integer('id_wall');
            $table->integer('id_user');
        });

        Schema::create('docs', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('file_url');
        });

        Schema::create('billets', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('file_url');
        });

        Schema::create('warnings', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->string('title');
            $table->string('status')->default('IN_REVIEW'); // IN_REVIEWS, RESOLVED
            $table->date('date_created');
            $table->text('photos'); //foto.jpg,foto2.jpg,foto3,jpg,foto4.jpg
        });

        Schema::create('foundandlost', function(Blueprint $table){
            $table->id();
            $table->string('status')->default('LOST'); // LOST, RECOVERED
            $table->string('photo'); //foto.jpg,foto2.jpg
            $table->string('description');
            $table->string('where');
            $table->date('date_created');
        });

        Schema::create('areas', function(Blueprint $table){
            $table->id();
            $table->integer('allowed')->default(1);
            $table->string('title');
            $table->string('cover');
            $table->string('days'); // 0,1,2,3,4,5,6
            $table->time('start_time');
            $table->time('end_time');
        });

        Schema::create('areadisableddays', function(Blueprint $table){
            $table->id();
            $table->integer('id_area');
            $table->date('day');
        });

        Schema::create('reservations', function(Blueprint $table){
            $table->id();
            $table->integer('id_unit');
            $table->integer('id_area');
            $table->datetime('reservation_date');
        });

        
    }


    // Reverse create tables
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('units');
        Schema::dropIfExists('unitpeoples');
        Schema::dropIfExists('unitvehicles');
        Schema::dropIfExists('unitpets');
        Schema::dropIfExists('walls');
        Schema::dropIfExists('walllikes');
        Schema::dropIfExists('docs');
        Schema::dropIfExists('billets');
        Schema::dropIfExists('warnings');
        Schema::dropIfExists('foundandlost');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('areadisableddays');
        Schema::dropIfExists('reservations');
    }
};
