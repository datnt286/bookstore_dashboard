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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->integer('num_pages')->nullable();
            $table->string('language')->nullable();
            $table->year('release_date')->nullable();
            $table->integer('price');
            $table->integer('e_book_price')->nullable();
            $table->integer('quantity');
            $table->string('link_download')->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
