<?php

namespace App\Models;

use App\Observers\PagesEntryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesEntry extends Model
{
    protected $table = "pages_entries";

    protected $fillable = [
        'study_entry_id',
        'read_pages',
        'notes',
        'date'
    ];
    
    /**
     * The "booting" method of the model.
     *
     * This method is called when the model is bootstrapped, and it registers the PagesEntryObserver.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        PagesEntry::observe(PagesEntryObserver::class);
    }

    /**
     * Define a many-to-one relationship with the StudyEntry model.
     *
     * This method defines a relationship where a pages entry belongs to a single study entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyEntry() 
    {
        return $this->belongsTo(StudyEntry::class, 'study_entry_id');
    }

    use HasFactory;
}
