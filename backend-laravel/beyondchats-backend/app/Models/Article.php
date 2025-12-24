<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'source_url',
        'source_type',
        'reference_urls',
    ];

    protected $casts = [
        'reference_urls' => 'array',
    ];
}
