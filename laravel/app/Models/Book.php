<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'isbn',
        'author',
        'publisher',
        'publication_year',
        'price',
        'stock',
        'cover',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function entries()
    {
        return $this->hasMany(BookEntry::class);
    }

    public function sales()
    {
        return $this->hasMany(BookSale::class);
    }
}