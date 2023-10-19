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

    protected static function boot()
    {
        parent::boot();
    
        StudyTrajectory::observe(StudyTrajectoryObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookEdition()
    {
        return $this->belongsTo(BookEdition::class, 'book_edition_id');
    }
}
