<?php

namespace App\Models;

use App\Observers\ReadMinutesEntryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadMinutesEntry extends Model
{
    protected $table = "read_minutes_entries";

    protected $fillable = [
        'study_entry_id',
        'read_pages',
        'date'
    ];
    
    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the ReadMinutesEntryObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        ReadMinutesEntry::observe(ReadMinutesEntryObserver::class);
    }

    /**
     * Define a many-to-one relationship with the StudyEntry model.
     *
     * This method defines a relationship where a read minutes entry belongs to a single study entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyEntry() 
    {
        return $this->belongsTo(StudyEntry::class, 'study_entry_id');
    }

    use HasFactory;
}