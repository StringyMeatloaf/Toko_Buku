    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\BookController;
    use App\Http\Controllers\BookEntryController;
    use App\Http\Controllers\InventoryController;
    use App\Http\Controllers\ReportController;

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::middleware(['auth'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');

        /*
        |--------------------------------------------------------------------------
        | Kategori Buku
        |--------------------------------------------------------------------------
        */

        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        /*
        |--------------------------------------------------------------------------
        | Daftar Buku
        |--------------------------------------------------------------------------
        */

        Route::get('/books', [BookController::class, 'index'])
            ->name('books.index');

        Route::get('/books/create', [BookController::class, 'create'])
            ->name('books.create');

        Route::post('/books', [BookController::class, 'store'])
            ->name('books.store');

        Route::get('/books/{book}/edit', [BookController::class, 'edit'])
            ->name('books.edit');

        Route::put('/books/{book}', [BookController::class, 'update'])
            ->name('books.update');

        Route::delete('/books/{book}', [BookController::class, 'destroy'])
            ->name('books.destroy');

        /*
    |--------------------------------------------------------------------------
    | Buku Masuk
    |--------------------------------------------------------------------------
    */

        Route::get('/book-entries', [BookEntryController::class, 'index'])
            ->name('book-entries.index');

        Route::get('/book-entries/create', [BookEntryController::class, 'create'])
            ->name('book-entries.create');

        Route::post('/book-entries', [BookEntryController::class, 'store'])
            ->name('book-entries.store');

        Route::get('/book-entries/{entry}/edit', [BookEntryController::class, 'edit'])
            ->name('book-entries.edit');

        Route::put('/book-entries/{entry}', [BookEntryController::class, 'update'])
            ->name('book-entries.update');

        Route::delete('/book-entries/{entry}', [BookEntryController::class, 'destroy'])
            ->name('book-entries.destroy');

        Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

        Route::get('/inventory/create', [InventoryController::class, 'create'])
    ->name('inventory.create');

        Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

        Route::get('/inventory/create', [InventoryController::class, 'create'])
            ->name('inventory.create');

        Route::post('/inventory', [InventoryController::class, 'store'])
            ->name('inventory.store');
        
        /*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

    });

    require __DIR__.'/auth.php';