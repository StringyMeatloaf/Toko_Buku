<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEntry;
use App\Models\BookSale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $day = $request->day;
        $month = $request->month;
        $year = $request->year;

        /*
        |--------------------------------------------------------------------------
        | Query Buku Masuk
        |--------------------------------------------------------------------------
        */

        $entriesQuery = BookEntry::with([
            'book',
            'book.category'
        ]);

        if ($day) {
            $entriesQuery->whereDay(
                'entry_date',
                $day
            );
        }

        if ($month) {
            $entriesQuery->whereMonth(
                'entry_date',
                $month
            );
        }

        if ($year) {
            $entriesQuery->whereYear(
                'entry_date',
                $year
            );
        }

        $entries = $entriesQuery
            ->get()
            ->map(function ($entry) {

                return [
                    'date' => $entry->entry_date,
                    'isbn' => $entry->book->isbn,
                    'title' => $entry->book->title,
                    'category' => $entry->book->category?->category_name,
                    'type' => 'Masuk',
                    'quantity' => $entry->quantity,
                    'stock' => $entry->book->stock,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Query Buku Keluar
        |--------------------------------------------------------------------------
        */

        $salesQuery = BookSale::with([
            'book',
            'book.category'
        ]);

        if ($day) {
            $salesQuery->whereDay(
                'sale_date',
                $day
            );
        }

        if ($month) {
            $salesQuery->whereMonth(
                'sale_date',
                $month
            );
        }

        if ($year) {
            $salesQuery->whereYear(
                'sale_date',
                $year
            );
        }

        $sales = $salesQuery
            ->get()
            ->map(function ($sale) {

                return [
                    'date' => $sale->sale_date,
                    'isbn' => $sale->book->isbn,
                    'title' => $sale->book->title,
                    'category' => $sale->book->category?->category_name,
                    'type' => 'Keluar',
                    'quantity' => $sale->quantity,
                    'stock' => $sale->book->stock,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::count();

        $totalStock = Book::sum('stock');

        $totalEntries = $entries
            ->sum('quantity');

        $totalSales = $sales
            ->sum('quantity');

        /*
        |--------------------------------------------------------------------------
        | Gabungkan Laporan
        |--------------------------------------------------------------------------
        */

        $reports = $entries
            ->merge($sales)
            ->sortByDesc('date')
            ->values();

        return view(
            'reports.index',
            compact(
                'reports',
                'totalBooks',
                'totalStock',
                'totalEntries',
                'totalSales',
                'day',
                'month',
                'year'
            )
        );
    }

    public function exportPdf(Request $request)
{
    $day = $request->day;
    $month = $request->month;
    $year = $request->year;

    $entriesQuery = BookEntry::with([
        'book',
        'book.category'
    ]);

    if ($day) {
        $entriesQuery->whereDay('entry_date', $day);
    }

    if ($month) {
        $entriesQuery->whereMonth('entry_date', $month);
    }

    if ($year) {
        $entriesQuery->whereYear('entry_date', $year);
    }

    $entries = $entriesQuery
        ->get()
        ->map(function ($entry) {

            return [
                'date' => $entry->entry_date,
                'isbn' => $entry->book->isbn,
                'title' => $entry->book->title,
                'category' => $entry->book->category?->category_name,
                'type' => 'Masuk',
                'quantity' => $entry->quantity,
                'stock' => $entry->book->stock,
            ];
        });

    $salesQuery = BookSale::with([
        'book',
        'book.category'
    ]);

    if ($day) {
        $salesQuery->whereDay('sale_date', $day);
    }

    if ($month) {
        $salesQuery->whereMonth('sale_date', $month);
    }

    if ($year) {
        $salesQuery->whereYear('sale_date', $year);
    }

    $sales = $salesQuery
        ->get()
        ->map(function ($sale) {

            return [
                'date' => $sale->sale_date,
                'isbn' => $sale->book->isbn,
                'title' => $sale->book->title,
                'category' => $sale->book->category?->category_name,
                'type' => 'Keluar',
                'quantity' => $sale->quantity,
                'stock' => $sale->book->stock,
            ];
        });

    $reports = $entries
        ->merge($sales)
        ->sortByDesc('date')
        ->values();

    $pdf = Pdf::loadView(
        'reports.pdf',
        compact(
            'reports',
            'day',
            'month',
            'year'
        )
    );

    return $pdf->download(
        'laporan-inventaris.pdf'
    );
}
}