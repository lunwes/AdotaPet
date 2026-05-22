<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    protected $table = 'especie';  // Confirme que é 'especie' (singular)
    
    protected $fillable = ['nome'];
    
    public $timestamps = true;
}