<?php

namespace App\Models;

use App\Observers\StudyEntryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyEntry extends Model
{
    protected $table = "study_entries";

    protected $fillable = [
        'study_trajectory_id',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the StudyEntryObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        StudyEntry::observe(StudyEntryObserver::class);
    }

    /**
     * Define a many-to-one relationship with the StudyTrajectory model.
     *
     * This method defines a relationship where a study entry belongs to a single study trajectory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyTrajectory() 
    {
        return $this->belongsTo(StudyTrajectory::class, 'study_trajectory_id');
    }

    public function pagesEntry()
    {
        return $this->hasOne(PagesEntry::class);
    }

    use HasFactory;
}
