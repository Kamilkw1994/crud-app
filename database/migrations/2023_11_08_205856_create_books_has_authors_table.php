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
        Schema::create('books_has_authors', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained('books')
                ->onDelete('cascade');

            $table->foreignId('author_id')
                ->constrained('authors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_has_authors');
    }
};
