<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEntry;
use App\Models\BookSale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();

        $totalEntries = BookEntry::sum('quantity');

        $totalSales = BookSale::sum('quantity');

        $totalStock = Book::sum('stock');

        /*
        |--------------------------------------------------------------------------
        | Data Grafik 6 Bulan Terakhir
        |--------------------------------------------------------------------------
        */

        $months = [];
        $entryData = [];
        $saleData = [];

        for ($i = 5; $i >= 0; $i--)
        {
            $date = now()->subMonths($i);

            $months[] = $date->format('M');

            $entryData[] = BookEntry::whereMonth(
                    'entry_date',
                    $date->month
                )
                ->whereYear(
                    'entry_date',
                    $date->year
                )
                ->sum('quantity');

            $saleData[] = BookSale::whereMonth(
                    'sale_date',
                    $date->month
                )
                ->whereYear(
                    'sale_date',
                    $date->year
                )
                ->sum('quantity');
        }

        /*
/*
|--------------------------------------------------------------------------
| Stok Tertinggi
|--------------------------------------------------------------------------
*/

$highestStockBooks = Book::orderByDesc('stock')
    ->limit(5)
    ->get();
/*
|--------------------------------------------------------------------------
| Stok Rendah
|--------------------------------------------------------------------------
*/

$lowStockBooks = Book::where('stock', '<=', 10)
    ->orderBy('stock')
    ->limit(5)
    ->get();

        return view(
    'dashboard.index',
    compact(
        'totalBooks',
        'totalEntries',
        'totalSales',
        'totalStock',
        'months',
        'entryData',
        'saleData',
        'highestStockBooks',
        'lowStockBooks'
    )
);
    }
}