<?php

namespace App\Models;

use App\Observers\BookObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    use HasFactory;

    protected $fillable = [
        'title',
        'publication_year',
        'description',
        'open_library_key',
        'editions_key',
        'author_id'
    ];

    protected static function boot()
    {
        parent::boot();
    
        Book::observe(BookObserver::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function editions()
    {
        return $this->hasMany(BookEdition::class);
    }
}