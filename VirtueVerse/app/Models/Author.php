<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}