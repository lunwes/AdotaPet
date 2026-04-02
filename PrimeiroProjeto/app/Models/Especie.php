<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    protected $table = 'especie';

    public $incrementing = true;

    protected $fillable = [
        'nome'
    ];
}
