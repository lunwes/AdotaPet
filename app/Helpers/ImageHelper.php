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
            return \App\Helpers\ImageHelper::url($caminho);
        } catch (\Exception $e) {
            // Fallback: retorna o caminho direto (pode não funcionar)
            return $caminho;
        }
    }
}