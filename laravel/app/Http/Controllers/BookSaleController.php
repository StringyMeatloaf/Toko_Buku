<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookSaleController extends Controller
{
    /**
     * Daftar transaksi penjualan
     */
    public function index()
    {
        $sales = BookSale::with([
            'book',
            'book.category'
        ])
        ->latest()
        ->get();

        return view(
            'inventory.book-sales.index',
            compact('sales')
        );
    }

    /**
     * Form tambah penjualan
     */
    public function create()
    {
        $books = Book::orderBy('title')
            ->get();

        return view(
            'inventory.book-sales.form',
            compact('books')
        );
    }

    /**
     * Simpan transaksi penjualan
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
            'sale_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable'
        ]);

        $book = Book::findOrFail(
            $request->book_id
        );

        if ($book->stock < $request->quantity) {

            return back()
                ->withErrors([
                    'quantity' => 'Stok buku tidak mencukupi.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $book) {

            BookSale::create([
                'book_id' => $request->book_id,
                'quantity' => $request->quantity,
                'sale_date' => $request->sale_date,
                'sale_price' => $request->sale_price,
                'notes' => $request->notes
            ]);

            $book->decrement(
                'stock',
                $request->quantity
            );
        });

        return redirect()
            ->route('book-sales.index')
            ->with(
                'success',
                'Data penjualan berhasil ditambahkan'
            );
    }

    /**
     * Form edit penjualan
     */
    public function edit(BookSale $sale)
    {
        $books = Book::orderBy('title')
            ->get();

        return view(
            'inventory.book-sales.form',
            compact(
                'sale',
                'books'
            )
        );
    }

    /**
     * Update penjualan
     */
    public function update(Request $request, BookSale $sale)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
            'sale_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable'
        ]);

        DB::transaction(function () use ($request, $sale) {

            // Kembalikan stok lama

            $oldBook = Book::findOrFail(
                $sale->book_id
            );

            $oldBook->increment(
                'stock',
                $sale->quantity
            );

            // Cek stok buku baru

            $newBook = Book::findOrFail(
                $request->book_id
            );

            if ($newBook->stock < $request->quantity) {
                throw new \Exception(
                    'Stok buku tidak mencukupi.'
                );
            }

            // Update transaksi

            $sale->update([
                'book_id' => $request->book_id,
                'quantity' => $request->quantity,
                'sale_date' => $request->sale_date,
                'sale_price' => $request->sale_price,
                'notes' => $request->notes
            ]);

            // Kurangi stok baru

            $newBook->decrement(
                'stock',
                $request->quantity
            );
        });

        return redirect()
            ->route('book-sales.index')
            ->with(
                'success',
                'Data penjualan berhasil diperbarui'
            );
    }

    /**
     * Hapus transaksi penjualan
     */
    public function destroy(BookSale $sale)
    {
        DB::transaction(function () use ($sale) {

            $book = Book::findOrFail(
                $sale->book_id
            );

            $book->increment(
                'stock',
                $sale->quantity
            );

            $sale->delete();
        });

        return redirect()
            ->route('book-sales.index')
            ->with(
                'success',
                'Data penjualan berhasil dihapus'
            );
    }
}