<?php

namespace App\Domains\Transport\Models;

use Database\Factories\Transport\TransporterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transporter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family',
        'national_code',
        'number',
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(
            Trip::class,
            'transporter_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return TransporterFactory::new();
    }
}
