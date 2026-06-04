<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus file lama

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->orderBy('title')->get();

        // Menambahkan data statistik untuk view index
        $totalBooks = $books->count();
        $totalStock = $books->sum('stock');
        $totalCategories = Category::count();
        $criticalStock = Book::where('stock', '<=', 10)->count();

        return view('master-data.books.index', compact(
            'books',
            'totalBooks',
            'totalStock',
            'totalCategories',
            'criticalStock'
        ));
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

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'author'      => 'required|max:255',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Sesuaikan nama input
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            // Simpan ke folder 'covers' di dalam storage/app/public
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'author'      => 'required|max:255',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        // Hapus file gambar dari storage saat data dihapus
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}
