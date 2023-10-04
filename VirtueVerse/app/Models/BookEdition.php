<?php

namespace App\Models;

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

    public function book()
    {
        return $this->belongsTo(Book::class);
    }}
