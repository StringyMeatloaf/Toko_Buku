<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('book_sales', function (Blueprint $table) {
        $table->id();

        $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();

        $table->integer('quantity');
        $table->date('sale_date');
        $table->decimal('sale_price', 10, 2)->nullable();
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_sales');
    }
};
