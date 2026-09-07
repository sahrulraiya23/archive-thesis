<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'title',
        'abstract',
        'type',
        'author',
        'program_study',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public static function getTypes()
    {
        return [
            'kcv' => 'Komputasi Cerdas dan Visual',
            'kbj' => 'Komputasi Berbasis Jaringan',
            'rpl' => 'Rekayasa Perangkat Lunak',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::getTypes()[$this->type] ?? strtoupper((string) $this->type);
    }

    public function getTypeCodeUpperAttribute(): string
    {
        return strtoupper((string) $this->type);
    }
}
