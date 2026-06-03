<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookSale extends Model
{
    protected $fillable = [
        'book_id',
        'quantity',
        'sale_date',
        'sale_price',
        'notes'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}