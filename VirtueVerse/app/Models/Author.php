<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CreatedByScope;
use Illuminate\Support\Facades\Log;
use App\Observers\AuthorObserver;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = [
        'name', 
        'birthdate', 
        'nationality', 
        'biography', 
        'open_library_key' // Add open_library_key for author key, similar to Book
    ];

    protected static function boot()
    {
        parent::boot();
    
        Author::observe(AuthorObserver::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}