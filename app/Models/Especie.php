<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    protected $table = 'especie'; // ou 'especies' dependendo do seu banco
    
    protected $fillable = ['nome'];
    
    public function animais()
    {
        return $this->hasMany(Animal::class);
    }
}