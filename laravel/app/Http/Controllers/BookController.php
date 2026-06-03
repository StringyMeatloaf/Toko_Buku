<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan halaman daftar buku
     */
    public function index()
    {
        $books = Book::with('category')
            ->orderBy('title')
            ->get();

        $categories = Category::orderBy('category_name')
            ->get();

        return view(
        'master-data.books.index',
        compact(
                'books',
                'categories'
    )
);
    }
    
        public function create()
    {
        $categories = Category::orderBy('category_name')
            ->get();

        return view(
            'master-data.books.form',
            compact('categories')
        );
    }

    /**
     * Menyimpan buku baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'title'            => 'required|max:255',
            'isbn'             => 'nullable|max:255',
            'author'           => 'required|max:255',
            'publisher'        => 'nullable|max:255',
            'publication_year' => 'nullable|integer',
            'price'            => 'nullable|numeric',
            'stock'            => 'nullable|integer|min:0',
            'description'      => 'nullable'
        ]);

        Book::create([
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'isbn'             => $request->isbn,
            'author'           => $request->author,
            'publisher'        => $request->publisher,
            'publication_year' => $request->publication_year,
            'price'            => $request->price ?? 0,
            'stock'            => $request->stock ?? 0,
            'description'      => $request->description,
        ]);

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Buku berhasil ditambahkan'
            );
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('category_name')
            ->get();

        return view(
            'master-data.books.form',
            compact(
                'book',
                'categories'
            )
        );
    }
    /**
     * Update buku
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'title'            => 'required|max:255',
            'isbn'             => 'nullable|max:255',
            'author'           => 'required|max:255',
            'publisher'        => 'nullable|max:255',
            'publication_year' => 'nullable|integer',
            'price'            => 'nullable|numeric',
            'stock'            => 'nullable|integer|min:0',
            'description'      => 'nullable'
        ]);

        $book->update([
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'isbn'             => $request->isbn,
            'author'           => $request->author,
            'publisher'        => $request->publisher,
            'publication_year' => $request->publication_year,
            'price'            => $request->price ?? 0,
            'stock'            => $request->stock ?? 0,
            'description'      => $request->description,
        ]);

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Buku berhasil diupdate'
            );
    }

    /**
     * Hapus buku
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Buku berhasil dihapus'
            );
    }
}