<?php

namespace App\Enums;

enum ClienteTipo: string
{
    case PARTICULAR = 'particular';
    case FLOTA = 'flota';
    case Empresa = 'empresa';
    case CONCESIONARIO = 'concesionario';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
