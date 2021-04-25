<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'author',
    ];

    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DocumentFile::class);
    }

    public function getUrlAttribute(): string
    {
        return route('document.index', [
            'document' => $this->id,
        ]);
    }
}
