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
        Schema::create('goods_recevied_note_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_recevied_note_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('combo_id')->nullable();
            $table->integer('import_price');
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('goods_recevied_note_id')->references('id')->on('goods_recevied_notes');
            $table->foreign('book_id')->references('id')->on('books')->nullable();
            $table->foreign('combo_id')->references('id')->on('combos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_recevied_note_details');
    }
};
