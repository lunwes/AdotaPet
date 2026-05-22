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
        
        // Para R2, use temporaryUrl
        try {
            return Storage::disk('r2')->temporaryUrl($caminho, now()->addHours(24));
        } catch (\Exception $e) {
            // Fallback: retorna o caminho direto (pode não funcionar)
            return $caminho;
        }
    }
}