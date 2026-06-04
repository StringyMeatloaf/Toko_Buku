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
    public function index()
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
            'sale_price' => 'nullable|numeric|min:0',
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
                    'sale_price' => $request->sale_price,
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
