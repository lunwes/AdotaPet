<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function url($caminho)
    {
        if (!$caminho) {
            return asset('images/sem-imagem.jpg');
        }
        
        // Gerar URL temporária de 24 horas
        return Storage::disk('r2')->temporaryUrl($caminho, now()->addHours(24));
    }
}