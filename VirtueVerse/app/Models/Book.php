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
        'author',
        'publication_year',
        'description',
        'open_library_key',
        'editions_key',
        'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function editions()
    {
        return $this->hasMany(BookEdition::class);
    }
}