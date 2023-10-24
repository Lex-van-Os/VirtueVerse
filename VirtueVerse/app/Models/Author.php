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
        'open_library_key'
    ];

    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the AuthorObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        Author::observe(AuthorObserver::class);
    }

    /**
     * Define a one-to-many relationship with the Book model.
     *
     * This method defines a relationship where an author can have many books.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}