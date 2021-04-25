<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
    protected $fillable = [
        'hash',
        'params'
    ];

    protected $casts = [
        'params' => 'array',
    ];

    public function getUrlAttribute(): string
    {
        return route('document-file', [
            'file' => $this->id,
        ]);
    }
}
