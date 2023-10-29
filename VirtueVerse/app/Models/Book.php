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

    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the BookObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        Book::observe(BookObserver::class);
    }

    /**
     * Define a many-to-one relationship with the Author model.
     *
     * This method defines a relationship where a book belongs to a single author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Define a one-to-many relationship with the BookEdition model.
     *
     * This method defines a relationship where a book can have many editions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function editions()
    {
        return $this->hasMany(BookEdition::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}