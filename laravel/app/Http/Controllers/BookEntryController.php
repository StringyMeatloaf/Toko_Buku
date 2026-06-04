<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookEntryController extends Controller
{
    /**
     * Daftar transaksi buku masuk
     */
    public function index()
    {
        $entries = BookEntry::with([
            'book',
            'book.category'
        ])
        ->latest()
        ->get();

        return view(
            'inventory.book-entries.index',
            compact('entries')
        );
    }

    /**
     * Form tambah buku masuk
     */
    public function create()
    {
        $books = Book::orderBy('title')
            ->get();

        return view(
            'inventory.book-entries.form',
            compact('books')
        );
    }

    /**
     * Simpan transaksi buku masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id'    => 'required|exists:books,id',
            'quantity'   => 'required|integer|min:1',
            'entry_date' => 'required|date',
            'notes'      => 'nullable'
        ]);

        DB::transaction(function () use ($request) {

            BookEntry::create([
                'book_id'    => $request->book_id,
                'quantity'   => $request->quantity,
                'entry_date' => $request->entry_date,
                'notes'      => $request->notes
            ]);

            $book = Book::findOrFail(
                $request->book_id
            );

            $book->increment(
                'stock',
                $request->quantity
            );
        });

        return redirect()
            ->route('book-entries.index')
            ->with(
                'success',
                'Data buku masuk berhasil ditambahkan'
            );
    }

    /**
     * Form edit transaksi
     */
    public function edit(BookEntry $entry)
    {
        $books = Book::orderBy('title')
            ->get();

        return view(
            'inventory.book-entries.form',
            compact(
                'entry',
                'books'
            )
        );
    }

    /**
     * Update transaksi buku masuk
     */
    public function update(Request $request, BookEntry $entry)
    {
        $request->validate([
            'book_id'    => 'required|exists:books,id',
            'quantity'   => 'required|integer|min:1',
            'entry_date' => 'required|date',
            'notes'      => 'nullable'
        ]);

        DB::transaction(function () use ($request, $entry) {

            // Kembalikan stok lama

            $oldBook = Book::findOrFail(
                $entry->book_id
            );

            $oldBook->decrement(
                'stock',
                $entry->quantity
            );

            // Update transaksi

            $entry->update([
                'book_id'    => $request->book_id,
                'quantity'   => $request->quantity,
                'entry_date' => $request->entry_date,
                'notes'      => $request->notes
            ]);

            // Tambahkan stok baru

            $newBook = Book::findOrFail(
                $request->book_id
            );

            $newBook->increment(
                'stock',
                $request->quantity
            );
        });

        return redirect()
            ->route('book-entries.index')
            ->with(
                'success',
                'Data buku masuk berhasil diperbarui'
            );
    }

    /**
     * Hapus transaksi buku masuk
     */
    public function destroy(BookEntry $entry)
    {
        DB::transaction(function () use ($entry) {

            $book = Book::findOrFail(
                $entry->book_id
            );

            $book->decrement(
                'stock',
                $entry->quantity
            );

            $entry->delete();
        });

        return redirect()
            ->route('book-entries.index')
            ->with(
                'success',
                'Data buku masuk berhasil dihapus'
            );
    }
}