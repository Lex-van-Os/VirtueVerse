<?php

namespace App\Models;

use App\Observers\NotesEntryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesEntry extends Model
{
    protected $table = "notes_entries";

    protected $fillable = [
        'study_entry_id',
        'notes',
        'date'
    ];
    
    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the NotesEntryObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        NotesEntry::observe(NotesEntryObserver::class);
    }

    /**
     * Define a many-to-one relationship with the StudyEntry model.
     *
     * This method defines a relationship where a notes entry belongs to a single study entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyEntry() 
    {
        return $this->belongsTo(StudyEntry::class, 'study_entry_id');
    }

    use HasFactory;
}
