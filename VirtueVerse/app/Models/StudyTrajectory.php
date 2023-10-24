<?php

namespace App\Models;

use App\Observers\StudyTrajectoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyTrajectory extends Model
{
    protected $table = 'study_trajectories';

    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'active', 
        'book_edition_id'
    ];

    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the StudyTrajectoryObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        StudyTrajectory::observe(StudyTrajectoryObserver::class);
    }

    /**
     * Define a many-to-one relationship with the User model.
     *
     * This method defines a relationship where a study trajectory belongs to a single user (created by).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Define a many-to-one relationship with the BookEdition model.
     *
     * This method defines a relationship where a study trajectory belongs to a single book edition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bookEdition()
    {
        return $this->belongsTo(BookEdition::class, 'book_edition_id');
    }
}
