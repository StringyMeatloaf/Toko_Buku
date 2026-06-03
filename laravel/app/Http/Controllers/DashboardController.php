<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEntry;
use App\Models\BookSale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();

        $totalEntries = BookEntry::sum('quantity');

        $totalSales = BookSale::sum('quantity');

        $totalStock = Book::sum('stock');

        return view('dashboard.index', compact(
            'totalBooks',
            'totalEntries',
            'totalSales',
            'totalStock'
        ));
    }
}