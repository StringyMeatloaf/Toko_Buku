<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEntry;
use App\Models\BookSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Halaman Inventaris Buku
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::count();

        $totalStock = Book::sum('stock');

        $lowStock = Book::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->count();

        $outOfStock = Book::where('stock', 0)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Buku Masuk
        |--------------------------------------------------------------------------
        */

        $entries = BookEntry::with([
            'book',
            'book.category'
        ])
        ->get()
        ->map(function ($entry) {

            return [
                'id' => $entry->id,
                'type' => 'Masuk',
                'book' => $entry->book,
                'quantity' => $entry->quantity,
                'notes' => $entry->notes,
                'date' => $entry->entry_date,
                'stock' => $entry->book->stock,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Buku Keluar
        |--------------------------------------------------------------------------
        */

        $sales = BookSale::with([
            'book',
            'book.category'
        ])
        ->get()
        ->map(function ($sale) {

            return [
                'id' => $sale->id,
                'type' => 'Keluar',
                'book' => $sale->book,
                'quantity' => $sale->quantity,
                'notes' => $sale->notes,
                'date' => $sale->sale_date,
                'stock' => $sale->book->stock,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Gabungkan Transaksi
        |--------------------------------------------------------------------------
        */

        $transactions = $entries
            ->merge($sales)
            ->sortByDesc('date')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Filter Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search'))
        {
            $transactions = $transactions->filter(function ($transaction) use ($request) {

                return str_contains(
                    strtolower($transaction['book']->title),
                    strtolower($request->search)
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tipe Transaksi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type'))
        {
            $transactions = $transactions->where(
                'type',
                $request->type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status Stok
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status'))
        {
            $transactions = $transactions->filter(function ($transaction) use ($request) {

                $stock = $transaction['stock'];

                switch ($request->status)
                {
                    case 'Tersedia':
                        return $stock > 10;

                    case 'Stok Rendah':
                        return $stock > 0 && $stock <= 10;

                    case 'Habis':
                        return $stock == 0;

                    default:
                        return true;
                }
            });
        }

        return view(
            'inventory.index',
            compact(
                'transactions',
                'totalBooks',
                'totalStock',
                'lowStock',
                'outOfStock'
            )
        );
    }

    /**
     * Form Tambah Transaksi
     */
    public function create()
    {
        $books = Book::with('category')
            ->orderBy('title')
            ->get();

        return view(
            'inventory.form',
            compact('books')
        );
    }

    /**
     * Simpan Transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable'
        ]);

        $book = Book::findOrFail(
            $request->book_id
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi Stok Buku Keluar
        |--------------------------------------------------------------------------
        */

        if (
            $request->transaction_type === 'sale'
            &&
            $book->stock < $request->quantity
        ) {

            return back()
                ->withErrors([
                    'quantity' => 'Stok buku tidak mencukupi.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $book) {

            /*
            |--------------------------------------------------------------------------
            | Buku Masuk
            |--------------------------------------------------------------------------
            */

            if ($request->transaction_type === 'entry')
            {
                BookEntry::create([
                    'book_id' => $request->book_id,
                    'quantity' => $request->quantity,
                    'entry_date' => $request->transaction_date,
                    'notes' => $request->notes
                ]);

                $book->increment(
                    'stock',
                    $request->quantity
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Buku Keluar
            |--------------------------------------------------------------------------
            */

            if ($request->transaction_type === 'sale')
            {
                BookSale::create([
                    'book_id' => $request->book_id,
                    'quantity' => $request->quantity,
                    'sale_date' => $request->transaction_date,
                    'notes' => $request->notes
                ]);

                $book->decrement(
                    'stock',
                    $request->quantity
                );
            }
        });

        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Transaksi berhasil disimpan.'
            );
    }
}