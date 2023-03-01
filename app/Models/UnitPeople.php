<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPeople extends Model
{
    use HasFactory;

    protected $hiden = [
        'id-unit'
    ];

    public $timestamps = false;

    public $table = 'unitpeoples';
}
