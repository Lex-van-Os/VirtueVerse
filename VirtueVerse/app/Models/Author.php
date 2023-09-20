<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = ['name', 'birthdate', 'nationality', 'biography', 'description'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}