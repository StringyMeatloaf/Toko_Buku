<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookEntry extends Model
{
    protected $fillable = [
        'book_id',
        'quantity',
        'entry_date',
        'notes'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}