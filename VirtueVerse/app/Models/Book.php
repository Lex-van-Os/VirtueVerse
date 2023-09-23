<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    use HasFactory;

    protected $fillable = [
        'title',
        'authour',
        'publication_year',
        'open_library_key',
    ];

    public function editions()
    {
        return $this->hasMany(BookEdition::class);
    }
}