<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AnimalFoto;

class Animal extends Model
{
    protected $table = 'animais';

    public $incrementing = true;

    protected $fillable = [
        'nome',
        'sexo',
        'sobre',
        'data_nascimento',
        'castracao',
        'especie_id',
        'adotado',
    ];

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }
    public function fotos()
    {
        return $this->hasMany(AnimalFoto::class, 'animal_id');
    }
    public function vacinas()
    {
        return $this->belongsToMany(Vacina::class, 'animal_vacinas', 'animal_id', 'vacina_id')
            ->withTimestamps();
    }
}
