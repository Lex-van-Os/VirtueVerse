<?php

namespace App\Models;

use App\Observers\BookEditionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookEdition extends Model
{
    use HasFactory;

    protected $table = 'book_editions';

    protected $fillable = [
        'title',
        'isbn',
        'language',
        'publication_year',
        'book_id',
        'editions_key',
        'pages',
    ];

    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the BookEditionObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        BookEdition::observe(BookEditionObserver::class);
    }

    /**
     * Define a many-to-one relationship with the Book model.
     *
     * This method defines a relationship where a book edition belongs to a single book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Define a one-to-many relationship with the StudyTrajectory model.
     *
     * This method defines a relationship where a book edition can be associated with many study trajectories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studyTrajectories()
    {
        return $this->hasMany(StudyTrajectory::class, 'book_edition_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
